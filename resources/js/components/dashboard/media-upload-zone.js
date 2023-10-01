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
    }

    // Événements enregistrables
    async onChoosenFile(file) {
        const event = new CustomEvent("OnChoosenFile", { detail: file });
        this.parentElement.dispatchEvent(event);

        let fileHash = md5(file.name + file.size + file.type);
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
                    const response = JSON.parse(xhr.responseText);
                    // Traiter la réponse ici, si nécessaire
                    resolve(response); // La requête est terminée avec succès
                } else {
                    this.showError("La communication avec le serveur a échoué, veuillez ouvrir la console pour obtenir plus d'informations.");
                    console.error(`HTTP error! Status: ${xhr.status}`);
                    reject(new Error(`HTTP error! Status: ${xhr.status}`)); // La requête a échoué
                }
            };

            xhr.send(data);
        });

        try {
            await uploadPromise;
            fileUploadProgressElem.classList.add("bg-success");
            fileUploadProgressElem.style.width = "100%";
            fileElemCloseBtn.style.display = "none";
            this.onFileUploaded(file);
        } catch (error) {
            // Gérer les erreurs ici (envoi annulé ou autre erreur)
            console.error(error.message);
        } finally {
            // Attendre 1 seconde avant de supprimer le fichier de la liste
            await new Promise(resolve => setTimeout(resolve, 1000));
            fileElem.remove();
            this.uploadingFiles = this.uploadingFiles.filter(item => item !== fileHash);

            if (this.uploadingFiles.length === 0) {
                this.onAllFileUploaded();
            }
        }
    }

    onFileUploaded(file) {
        const event = new CustomEvent("OnFileUploaded", {detail: file});
        this.parentElement.dispatchEvent(event);
    }

    onAllFileUploaded() {
        const event = new CustomEvent("OnAllFileUploaded");
        this.parentElement.dispatchEvent(event);

        if (this.uploadingFiles.length === 0) {
            this.hasAlreadyUploadedFiles = false;
            this.parentElement.getElementsByClassName("no-file-uploaded-yet")[0].style.display = "";
            this.fileListElem.style.display = "none";
        }
    }

    // Méthodes internes
    dragOver(e) {
        e.preventDefault();
        // Ajoute une classe CSS pour indiquer que l'élément est survolé
        this.parentElement.classList.add("drag-over");
    }

    dragLeave(e) {
        e.preventDefault();
        // Supprime la classe CSS lorsque l'élément n'est plus survolé
        this.parentElement.classList.remove("drag-over");
    }

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

    async processFiles(files) {
        if (files.length === 0) return;

        if (!this.hasAlreadyUploadedFiles) {
            this.hasAlreadyUploadedFiles = true;
            this.parentElement.getElementsByClassName("no-file-uploaded-yet")[0].style.display = "none";
            this.fileListElem.style.display = "flex";
        }

        const successfullyFetchedFiles = [];
        const uploadPromises = [];

        for (const file of Array.from(files)) {
            const fileHash = md5(file.name + file.size + file.type);

            if (this.acceptFileTypes.length > 0 && !this.acceptFileTypes.includes(file.type)) {
                this.showError("Le type de fichier " + file.type + " n'est pas accepté !");
                continue;
            }

            if (this.uploadingFiles.includes(fileHash)) {
                this.showError("Le fichier " + file.name + " est déjà envoyé ou en cours d'envoi !");
                continue;
            }

            this.uploadingFiles.push(fileHash);

            const fileType = file.type === "" ? file.name.split(".").pop() : file.type;
            const data = new FormData();
            data.append("name", file.name);
            data.append("size", file.size);
            data.append("type", fileType);

            const fetchPromise = fetch(route("dashboard.ajax.components.media-upload-zone.get-rendered-file-list-component", undefined, undefined, Ziggy), {
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
                .then(async fileDomElem => {
                    this.fileListElem.innerHTML += fileDomElem;
                    successfullyFetchedFiles.push(file);
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                });

            uploadPromises.push(fetchPromise);
        }

        // Attendre que toutes les requêtes de téléchargement soient terminées
        await Promise.all(uploadPromises);

        // Ensuite, envoyer les fichiers téléchargés
        for (const file of successfullyFetchedFiles) {
            await this.onChoosenFile(file);
        }
    }

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

    showError(errorMessage) {
        let newFileErrorModel = this.fileErrorModel.cloneNode(true);
        newFileErrorModel.style.display = "";
        newFileErrorModel.id = "";
        newFileErrorModel.getElementsByClassName("file-error-message")[0].innerText = errorMessage;

        let fileElemCloseBtn = newFileErrorModel.getElementsByClassName("file-close-btn")[0];
        fileElemCloseBtn.addEventListener("click", () => {
            newFileErrorModel.remove();
        });
        this.fileListElem.append(newFileErrorModel);
    }
}

export default MediaUploadZone;
