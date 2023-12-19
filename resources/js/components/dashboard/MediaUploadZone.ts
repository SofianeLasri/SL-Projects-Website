import route from 'ziggy-js';
import md5 from "blueimp-md5";
import {LaravelValidationError, MUZUploadedFileResponse} from "../../types";

class MediaUploadZone {
    parentElement: HTMLElement;
    hasAlreadyUploadedFiles: boolean = false;
    uploadingFiles: string[] = [];
    csrfToken: string;
    fileListElem: HTMLElement;
    fileErrorModel: HTMLElement;
    sendFileBtn: HTMLElement;
    acceptFileTypes: string[] = [];
    fileRowModel: HTMLElement;
    homeScreenElem: HTMLElement;

    constructor(id = "mediaUploadZone") {
        this.csrfToken = this.getCSRFToken();

        let foundParentElement: HTMLElement | null = document.getElementById(id);
        if (foundParentElement === null) {
            throw new Error("MediaUploadZone: Parent element not found");
        }
        this.parentElement = foundParentElement;

        this.parentElement.addEventListener("dragover", this.dragOver.bind(this));
        this.parentElement.addEventListener("dragleave", this.dragLeave.bind(this));
        this.parentElement.addEventListener("drop", this.drop.bind(this));

        let fileListElem: Element | null = this.parentElement.getElementsByClassName("file-upload-list").item(0);
        if (fileListElem === null) {
            throw new Error("MediaUploadZone: File list element not found");
        }
        this.fileListElem = fileListElem as HTMLElement;

        let fileErrorModel: HTMLElement | null = document.getElementById("fileErrorModel");
        if (fileErrorModel === null) {
            throw new Error("MediaUploadZone: File error model element not found");
        }
        this.fileErrorModel = fileErrorModel;

        let sendFileBtn: HTMLElement | null = document.getElementById("mediaUploadZoneSendFileBtn");
        if (sendFileBtn === null) {
            throw new Error("MediaUploadZone: Send file button not found");
        }
        this.sendFileBtn = sendFileBtn;
        this.sendFileBtn.addEventListener("click", this.sendFileBtnFunc.bind(this));

        let fileRowModel: HTMLElement | null = document.getElementById("fileModel");
        if (fileRowModel === null) {
            throw new Error("MediaUploadZone: File row model not found");
        }
        this.fileRowModel = fileRowModel;

        let homeScreenElem: HTMLElement | null = this.parentElement.getElementsByClassName("no-file-uploaded-yet").item(0) as HTMLElement | null;
        if (homeScreenElem === null) {
            throw new Error("MediaUploadZone: Home screen element not found (.no-file-uploaded-yet)");
        }
        this.homeScreenElem = homeScreenElem;
    }

    private getCSRFToken(): string {
        const csrfTokenElem = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenElem?.getAttribute('content') || '';
        if (!csrfToken) {
            console.error("MediaUploadZone: CSRF token not found");
        }
        return csrfToken;
    }

    // Événements enregistrables
    /**
     * Lorqu'un fichier est choisi, cette méthode est appelée
     * @param file Le fichier choisi
     * @returns {Promise<void>}
     */
    async onChoosenFile(file: File): Promise<void> {
        const event = new CustomEvent("OnChoosenFile", {detail: file});
        this.parentElement.dispatchEvent(event);

        const fileType = file.type === "" ? file.name.split(".").pop() : file.type;

        let fileHash = md5(file.name + file.size + fileType);
        let fileElemName = "muzf-" + fileHash;
        let fileElem: HTMLElement | null = document.getElementById(fileElemName);
        if (fileElem === null) {
            console.error("MediaUploadZone: File element not found");
            this.showError("Le fichier " + file.name + " n'a pas été trouvé dans la liste des fichiers en cours d'envoi.");
            return;
        }
        let fileUploadProgressElem: HTMLElement = fileElem.getElementsByClassName("progress").item(0) as HTMLElement;
        let fileElemCloseBtn: HTMLElement = fileElem.getElementsByClassName("file-close-btn").item(0) as HTMLElement;

        let cancelUpload = false;

        // Gestionnaire pour le bouton "close" qui annule l'envoi du fichier
        fileElemCloseBtn.addEventListener("click", () => {
            if (fileElem) {
                fileElem.remove();
            }
            this.uploadingFiles = this.uploadingFiles.filter(item => item !== fileHash);
            cancelUpload = true; // Marquer l'envoi comme annulé

            this.showHomeIfNoFile();
        });

        let data = new FormData();
        data.append("file", file);

        // Utiliser une promesse pour gérer l'envoi du fichier
        const uploadPromise = new Promise(async (resolve, reject) => {
            const xhr: XMLHttpRequest = new XMLHttpRequest();

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

            xhr.open("POST", route("dashboard.ajax.components.media-upload-zone.upload-file"));
            xhr.setRequestHeader('X-CSRF-TOKEN', this.csrfToken);
            xhr.setRequestHeader('Accept', 'application/json');

            xhr.onload = () => {
                if (cancelUpload) {
                    reject(new Error("L'envoi a été annulé"));
                } else if (xhr.status === 200) {
                    let response = xhr.responseText;
                    try {
                        let parsedResponse: MUZUploadedFileResponse = JSON.parse(response);
                        console.log(parsedResponse); // TODO: Remove debug
                        resolve(parsedResponse);
                    } catch (e) {
                        this.showError("La communication avec le serveur a échoué, veuillez ouvrir la console pour obtenir plus d'informations.");
                        console.error("Response is not json!");
                        console.error(response);
                        reject(new Error("Response is not json!"));
                    }
                } else if (xhr.status === 422) {
                    let response = xhr.responseText;
                    this.showError("Le fichier " + file.name + " n'a pas pu être traité. Veuillez ouvrir la console ou lire les logs pour obtenir plus d'informations.");
                    console.error(xhr.responseText);
                    console.error(file);
                    reject(new Error(`HTTP error! Status: ${xhr.status}`));
                } else if (xhr.status === 413) {
                    let response = xhr.responseText;
                    this.showError("Le fichier " + file.name + " est trop volumineux. Veuillez ouvrir la console ou lire les logs pour obtenir plus d'informations.");
                    console.error(xhr.responseText);
                    reject(new Error(`HTTP error! Status: ${xhr.status}`));
                } else {
                    // We want to check if the response is application/json
                    if(xhr.getResponseHeader("Content-Type") === "application/json") {
                        let response = xhr.responseText;
                        try {
                            let errorDetail: LaravelValidationError = JSON.parse(response);
                            console.error(errorDetail);
                            this.showError(errorDetail.message);
                            reject(new Error(errorDetail.message));
                        } catch (e) {
                            this.showError("La communication avec le serveur a échoué, veuillez ouvrir la console pour obtenir plus d'informations.");
                            console.error("Error response is not json but header content type is defined as json.");
                            console.error(response);
                            reject(new Error("Error response is not json but header content type is defined as json."));
                        }
                    }

                    this.showError("La communication avec le serveur a échoué, veuillez ouvrir la console pour obtenir plus d'informations.");
                    console.error(`HTTP error! Status: ${xhr.status}`);
                    console.error(xhr.responseText);
                    reject(new Error(`HTTP error! Status: ${xhr.status}`));
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
        } catch (error: any) {
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
    onFileUploaded(file: File) {
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
    dragOver(e: DragEvent) {
        e.preventDefault();
        // Ajoute une classe CSS pour indiquer que l'élément est survolé
        this.parentElement.classList.add("drag-over");
    }

    /**
     * Méthode appelée lorsque la zone d'envoi n'est plus survolé avec un fichier
     * @param e
     */
    dragLeave(e: DragEvent) {
        e.preventDefault();
        // Supprime la classe CSS lorsque l'élément n'est plus survolé
        this.parentElement.classList.remove("drag-over");
    }

    /**
     * Méthode appelée lorsque des fichiers sont déposés dans la zone d'envoi
     * @param e
     */
    drop(e: DragEvent) {
        e.preventDefault();

        if (this.uploadingFiles.length > 0) {
            // Afficher un message d'erreur si des fichiers sont déjà en cours d'envoi
            this.showError("Des fichiers sont déjà en cours d'envoi. Attendez qu'ils soient terminés.");
            return;
        }

        this.parentElement.classList.remove("drag-over");
        if (e.dataTransfer === null) return;
        this.processFiles(e.dataTransfer.files);
    }

    /**
     * Méthode appelée pour traiter les fichiers déposés ou choisis
     * @param files
     * @returns {Promise<void>}
     */
    async processFiles(files: FileList): Promise<void> {
        if (files.length === 0) return;

        if (!this.hasAlreadyUploadedFiles) {
            this.hasAlreadyUploadedFiles = true;
            this.homeScreenElem.style.display = "none";
            this.fileListElem.style.display = "flex";
        }

        for (const file of Array.from(files)) {
            let fileType: string;
            if (file.type === "") {
                let fileNameParts = file.name.split(".");
                fileType = fileNameParts[fileNameParts.length - 1];
            } else {
                fileType = file.type;
            }
            const fileHash: string = md5(file.name + file.size + fileType);

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

        fileInput.addEventListener("change", (e: Event) => {
            if (e.target === null) return;
            let fileInput = e.target as HTMLInputElement;
            if (fileInput.files === null) return;

            this.processFiles(fileInput.files);
        });
        fileInput.click();
    }

    /**
     * Méthode appelée pour afficher une erreur
     * @param errorMessage
     */
    showError(errorMessage: string): void {
        let newFileErrorModel: HTMLElement = this.fileErrorModel.cloneNode(true) as HTMLElement;
        newFileErrorModel.style.display = "";
        newFileErrorModel.id = "";

        let fileErrorMessage: HTMLElement | null = newFileErrorModel.querySelector(".file-error-message") as HTMLElement | null;
        if (fileErrorMessage) {
            fileErrorMessage.innerText = errorMessage;
        }

        let fileElemCloseBtn: HTMLElement | null = newFileErrorModel.querySelector(".file-close-btn") as HTMLElement | null;
        if (fileElemCloseBtn) {
            fileElemCloseBtn.addEventListener("click", () => {
                newFileErrorModel.remove();
                this.showHomeIfNoFile();
            });
        }

        this.fileListElem.append(newFileErrorModel);
    }


    /**
     * Méthode appelée pour afficher une ligne de fichier dans la liste
     * @param name Le nom du fichier
     * @param size La taille du fichier
     * @param type Le type du fichier
     * @param hash Le hash du fichier
     */
    async showFileRow(name: string, size: number, type: string, hash: string) {
        let newFileRowModel: HTMLElement = this.fileRowModel.cloneNode(true) as HTMLElement
        newFileRowModel.style.display = "";
        newFileRowModel.id = "muzf-" + hash;

        let iconElem = newFileRowModel.getElementsByClassName("file-icon")[0];
        const data = new FormData();
        data.append("type", type);
        const fetchPromise = fetch(route("dashboard.ajax.components.media-upload-zone.find-icon"), {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json',
            },
            body: data,
        })
            .then(async response => {
                if (!response.ok) {
                    this.showError("La communication avec le serveur a échoué, veuillez ouvrir la console pour obtenir plus d'informations.");
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                let responseJson = await response.json();
                return responseJson.icon;
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

        let fileElemName: HTMLElement | null = newFileRowModel.getElementsByClassName("name").item(0) as HTMLElement | null;
        if (fileElemName === null) {
            throw new Error("MediaUploadZone: File name element not found");
        }
        fileElemName.innerText = name;

        let fileElemSize: HTMLElement | null = newFileRowModel.getElementsByClassName("size").item(0) as HTMLElement | null;
        if (fileElemSize === null) {
            throw new Error("MediaUploadZone: File size element not found");
        }
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
            this.homeScreenElem.style.display = "";
            this.fileListElem.style.display = "none";
        }
    }

    /**
     * Méthode appelée pour formater la taille d'un fichier
     * @param size La taille du fichier en octets
     * @returns {string} La taille formatée
     */
    formatBytes(size: number): string {
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
