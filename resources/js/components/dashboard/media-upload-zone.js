import route from 'ziggy';
import {Ziggy} from '@/ziggy';
import md5 from "blueimp-md5";

class MediaUploadZone {
    parentElement;
    hasAlreadyUploadedFiles = false;
    uploadingFiles = [];
    csrfToken;
    fileListElem;
    fileErrorModel;
    sendFileBtn;
    acceptFileTypes = [];
    fileRowModel;

    constructor(id = "mediaUploadZone") {
        this.parentElement = document.getElementById(id);
        if (this.parentElement === null) {
            console.error("MediaUploadZone: Parent element not found");
            return;
        }

        this.parentElement.addEventListener("dragover", this.dragOver.bind(this));
        this.parentElement.addEventListener("dragleave", this.dragLeave.bind(this));
        this.parentElement.addEventListener("drop", this.drop.bind(this));

        this.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.fileListElem = this.parentElement.getElementsByClassName("file-upload-list")[0];
        this.fileErrorModel = document.getElementById("fileErrorModel");
        this.sendFileBtn = document.getElementById("mediaUploadZoneSendFileBtn");
        this.sendFileBtn.addEventListener("click", this.sendFileBtnFunc.bind(this));
        this.fileRowModel = document.getElementById("fileModel");
    }

    // Événements enregistrables
    /**
     * Lorqu'un fichier est choisi, cette méthode est appelée
     * @param file Le fichier choisi
     * @returns {Promise<void>}
     */
    async onChoosenFile(file) {
        const event = new CustomEvent("OnChoosenFile", {detail: file});
        this.parentElement.dispatchEvent(event);

        const fileType = file.type === "" ? file.name.split(".").pop() : file.type;

        let fileHash = md5(file.name + file.size + fileType);
        let fileElemName = "muzf-" + fileHash;
        let fileElem = document.getElementById(fileElemName);
        let fileUploadProgressElem = fileElem.getElementsByClassName("progress")[0];
        let fileElemCloseBtn = fileElem.getElementsByClassName("file-close-btn")[0];

        let cancelUpload = false;

        // Gestionnaire pour le bouton "close" qui annule l'envoi du fichier
        fileElemCloseBtn.addEventListener("click", () => {
            fileElem.remove();
            this.uploadingFiles = this.uploadingFiles.filter(item => item !== fileHash);
            cancelUpload = true; // Marquer l'envoi comme annulé

            this.showHomeIfNoFile();
        });

        let data = new FormData();
        data.append("file", file);

        // Utiliser une promesse pour gérer l'envoi du fichier
        const uploadPromise = new Promise(async (resolve, reject) => {
            const xhr = new XMLHttpRequest();

            // Événement pour surveiller l'avancement de l'envoi
            xhr.upload.addEventListener("progress", function (event) {
                if (event.lengthComputable) {
                    const percentComplete = (event.loaded / event.total) * 100;
                    fileUploadProgressElem.style.width = percentComplete + "%";

                    if (cancelUpload) {
                        xhr.abort(); // Annuler la requête si l'envoi est annulé
                    }
                }
            });

            xhr.open("POST", route("dashboard.ajax.components.media-upload-zone.upload-file", undefined, undefined, Ziggy));
            xhr.setRequestHeader('X-CSRF-TOKEN', this.csrfToken);

            xhr.onload = () => {
                if (cancelUpload) {
                    reject(new Error("L'envoi a été annulé"));
                } else if (xhr.status === 200) {
                    // Check if anwer is json
                    let response = xhr.responseText;
                    try {
                        response = JSON.parse(response);
                        console.log(response);
                        resolve(response);
                    } catch (e) {
                        console.error("Response is not json!");
                        console.error(response);
                    }
                } else {
                    this.showError("La communication avec le serveur a échoué, veuillez ouvrir la console pour obtenir plus d'informations.");
                    console.error(`HTTP error! Status: ${xhr.status}`);
                    console.error(xhr.responseText);
                    reject(new Error(`HTTP error! Status: ${xhr.status}`)); // La requête a échoué
                }
            };

            xhr.send(data);
        });

        try {
            await uploadPromise;
            fileUploadProgressElem.classList.add("bg-success");
            fileUploadProgressElem.style.width = "100%";
            // fileElemCloseBtn.style.display = "none";
            this.onFileUploaded(file);
        } catch (error) {
            // Gérer les erreurs ici (envoi annulé ou autre erreur)
            console.error(error.message);
        } finally {
            this.uploadingFiles = this.uploadingFiles.filter(item => item !== fileHash);

            if (this.uploadingFiles.length === 0) {
                this.onAllFileUploaded();
            }
        }
    }

    /**
     * Lorsqu'un fichier est envoyé, cette méthode est appelée
     * @param file Le fichier envoyé
     */
    onFileUploaded(file) {
        const event = new CustomEvent("OnFileUploaded", {detail: file});
        this.parentElement.dispatchEvent(event);
    }

    /**
     * Lorsque tous les fichiers sont envoyés, cette méthode est appelée
     */
    onAllFileUploaded() {
        const event = new CustomEvent("OnAllFileUploaded");
        this.parentElement.dispatchEvent(event);

        this.showHomeIfNoFile();
    }

    // Méthodes
    /**
     * Méthode appelée lorsque la zone d'envoi est survolé avec un fichier
     * @param e
     */
    dragOver(e) {
        e.preventDefault();
        // Ajoute une classe CSS pour indiquer que l'élément est survolé
        this.parentElement.classList.add("drag-over");
    }

    /**
     * Méthode appelée lorsque la zone d'envoi n'est plus survolé avec un fichier
     * @param e
     */
    dragLeave(e) {
        e.preventDefault();
        // Supprime la classe CSS lorsque l'élément n'est plus survolé
        this.parentElement.classList.remove("drag-over");
    }

    /**
     * Méthode appelée lorsque des fichiers sont déposés dans la zone d'envoi
     * @param e
     */
    drop(e) {
        e.preventDefault();

        if (this.uploadingFiles.length > 0) {
            // Afficher un message d'erreur si des fichiers sont déjà en cours d'envoi
            this.showError("Des fichiers sont déjà en cours d'envoi. Attendez qu'ils soient terminés.");
            return;
        }

        this.parentElement.classList.remove("drag-over");
        this.processFiles(e.dataTransfer.files);
    }

    /**
     * Méthode appelée pour traiter les fichiers déposés ou choisis
     * @param files
     * @returns {Promise<void>}
     */
    async processFiles(files) {
        if (files.length === 0) return;

        if (!this.hasAlreadyUploadedFiles) {
            this.hasAlreadyUploadedFiles = true;
            this.parentElement.getElementsByClassName("no-file-uploaded-yet")[0].style.display = "none";
            this.fileListElem.style.display = "flex";
        }

        for (const file of Array.from(files)) {
            const fileType = file.type === "" ? file.name.split(".").pop() : file.type;
            const fileHash = md5(file.name + file.size + fileType);

            if (this.acceptFileTypes.length > 0 && !this.acceptFileTypes.includes(fileType)) {
                this.showError("Le type de fichier " + fileType + " n'est pas accepté !");
                continue;
            }

            if (this.uploadingFiles.includes(fileHash)) {
                this.showError("Le fichier " + file.name + " est déjà envoyé ou en cours d'envoi !");
                continue;
            }

            this.uploadingFiles.push(fileHash);

            await this.showFileRow(file.name, file.size, fileType, fileHash);
        }

        // Ensuite, envoyer les fichiers téléchargés
        for (const file of files) {
            await this.onChoosenFile(file);
        }
    }

    /**
     * Méthode appelée lorsque le bouton d'envoi de fichier est cliqué
     */
    sendFileBtnFunc() {
        // On créé un input file pour envoyer les fichiers
        const fileInput = document.createElement("input");
        fileInput.type = "file";
        fileInput.multiple = true;

        if (this.acceptFileTypes.length > 0) {
            fileInput.accept = this.acceptFileTypes.join(",");
        }

        fileInput.addEventListener("change", (e) => {
            this.processFiles(e.target.files);
        });
        fileInput.click();
    }

    /**
     * Méthode appelée pour afficher une erreur
     * @param errorMessage
     */
    showError(errorMessage) {
        let newFileErrorModel = this.fileErrorModel.cloneNode(true);
        newFileErrorModel.style.display = "";
        newFileErrorModel.id = "";
        newFileErrorModel.getElementsByClassName("file-error-message")[0].innerText = errorMessage;

        let fileElemCloseBtn = newFileErrorModel.getElementsByClassName("file-close-btn")[0];
        fileElemCloseBtn.addEventListener("click", () => {
            newFileErrorModel.remove();
            this.showHomeIfNoFile();
        });
        this.fileListElem.append(newFileErrorModel);
    }

    /**
     * Méthode appelée pour afficher une ligne de fichier dans la liste
     * @param name Le nom du fichier
     * @param size La taille du fichier
     * @param type Le type du fichier
     * @param hash Le hash du fichier
     */
    async showFileRow(name, size, type, hash) {
        let newFileRowModel = this.fileRowModel.cloneNode(true);
        newFileRowModel.style.display = "";
        newFileRowModel.id = "muzf-" + hash;

        let iconElem = newFileRowModel.getElementsByClassName("file-icon")[0];
        const data = new FormData();
        data.append("type", type);
        const fetchPromise = fetch(route("dashboard.ajax.components.media-upload-zone.find-icon", undefined, undefined, Ziggy), {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
            },
            body: data,
        })
            .then(async response => {
                if (!response.ok) {
                    this.showError("La communication avec le serveur a échoué, veuillez ouvrir la console pour obtenir plus d'informations.");
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.text();
            })
            .then(async icon => {
                let classes = icon.split(" ");
                for (const classElem of classes) {
                    iconElem.classList.add(classElem);
                }
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
            });

        let fileElemName = newFileRowModel.getElementsByClassName("name")[0];
        fileElemName.innerText = name;

        let fileElemSize = newFileRowModel.getElementsByClassName("size")[0];
        fileElemSize.innerText = this.formatBytes(size);

        await fetchPromise;

        this.fileListElem.append(newFileRowModel);
    }

    /**
     * Méthode appelée pour afficher la page d'accueil si aucun fichier n'est présent
     */
    showHomeIfNoFile() {
        if (this.fileListElem.children.length === 0) {
            this.hasAlreadyUploadedFiles = false;
            this.parentElement.getElementsByClassName("no-file-uploaded-yet")[0].style.display = "";
            this.fileListElem.style.display = "none";
        }
    }

    /**
     * Méthode appelée pour formater la taille d'un fichier
     * @param size La taille du fichier en octets
     * @returns {string} La taille formatée
     */
    formatBytes(size) {
        const units = ['o', 'Ko', 'Mo', 'Go', 'To'];
        let unitIndex = 0;

        while (size > 1024) {
            size /= 1024;
            unitIndex++;
        }

        return size.toFixed(2) + ' ' + units[unitIndex];
    }
}

export default MediaUploadZone;
