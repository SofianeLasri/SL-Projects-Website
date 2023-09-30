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
    onChoosenFile(file) {
        const event = new CustomEvent("OnChoosenFile", {detail: file});
        this.parentElement.dispatchEvent(event);

        console.log("checkpoint");
        let fileElemName = "muzf-" + md5(file.name + file.size + file.type);

        console.log("checkpoint 2");
        let fileElem = document.getElementById(fileElemName);
        let fileUploadProgressElem = fileElem.getElementsByClassName("progress")[0];

        let data = new FormData();
        data.append("file", file);

        console.log("Uploading file " + file.name + " to " + route("dashboard.ajax.components.media-upload-zone.upload-file", undefined, undefined, Ziggy));
        let xhr = new XMLHttpRequest();

        // Événement pour surveiller l'avancement de l'envoi
        xhr.upload.addEventListener("progress", function (event) {
            if (event.lengthComputable) {
                const percentComplete = (event.loaded / event.total) * 100;
                fileUploadProgressElem.style.width = percentComplete + "%";
            }
        });

        xhr.open("POST", route("dashboard.ajax.components.media-upload-zone.upload-file", undefined, undefined, Ziggy));
        xhr.setRequestHeader('X-CSRF-TOKEN', this.csrfToken);

        xhr.onload = () => {
            console.log(xhr.responseText);
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                // Traiter la réponse ici, si nécessaire

            } else {
                this.showError("La communication avec le serveur a échoué, veuillez ouvrir la console pour obtenir plus d'informations.");
                console.error(`HTTP error! Status: ${xhr.status}`);
            }
        };

        xhr.send(data);
    }

    onFileUploaded(file) {
        const event = new CustomEvent("OnFileUploaded", {detail: file});
        this.parentElement.dispatchEvent(event);
    }

    onAllFileUploaded() {
        const event = new CustomEvent("OnAllFileUploaded");
        this.parentElement.dispatchEvent(event);
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
        this.parentElement.classList.remove("drag-over");
        this.processFiles(e.dataTransfer.files);
    }

    processFiles(files) {
        if (files.length > 0) {
            if (!this.hasAlreadyUploadedFiles) {
                this.hasAlreadyUploadedFiles = true;
                this.parentElement.getElementsByClassName("no-file-uploaded-yet")[0].style.display = "none";
                this.fileListElem.style.display = "flex";
            }

            Array.from(files).forEach(file => {
                console.log(file);
                if (this.acceptFileTypes.length > 0) {
                    if (!this.acceptFileTypes.includes(file.type)) {
                        this.showError("Le type de fichier " + file.type + " n'est pas accepté !");
                        return;
                    }
                }
                this.uploadingFiles.push(file);

                // On va récupérer la template HTML pour chaque fichier
                let fileType = file.type;
                if (file.type === "") {
                    fileType = file.name.split(".").pop();
                }

                const data = new FormData();
                data.append("name", file.name);
                data.append("size", file.size);
                data.append("type", fileType);

                fetch(route("dashboard.ajax.components.media-upload-zone.get-rendered-file-list-component", undefined, undefined, Ziggy), {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': this.csrfToken,
                    },
                    body: data,
                })
                    .then(response => {
                        if (!response.ok) {
                            this.showError("La communication avec le serveur a échoué, veuillez ouvrir la console pour obtenir plus d'informations.");
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(fileDomElem => {
                        this.fileListElem.innerHTML += fileDomElem;
                        this.onChoosenFile(file);
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                    });
            });
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
        this.fileListElem.append(newFileErrorModel);
    }
}

export default MediaUploadZone;
