import route from 'ziggy';
import { Ziggy } from '../ziggy';

class MediaUploadZone {
    parentElement;
    hasAlreadyUploadedFiles = false;
    uploadingFiles = [];

    constructor(id = "mediaUploadZone") {
        this.parentElement = document.getElementById(id);
        if (this.parentElement === null) {
            console.error("MediaUploadZone: Parent element not found");
            return;
        }

        this.parentElement.addEventListener("dragover", this.dragOver.bind(this));
        this.parentElement.addEventListener("dragleave", this.dragLeave.bind(this));
        this.parentElement.addEventListener("drop", this.drop.bind(this));
    }

    // Événements enregistrables
    onChoosenFile(file) {
        const event = new CustomEvent("OnChoosenFile", {detail: file});
        this.parentElement.dispatchEvent(event);
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

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const fileListElem = this.parentElement.getElementsByClassName("file-upload-list")[0];
            if (!this.hasAlreadyUploadedFiles) {
                this.hasAlreadyUploadedFiles = true;
                this.parentElement.getElementsByClassName("no-file-uploaded-yet")[0].style.display = "none";
                fileListElem.style.display = "flex";
            }

            console.log("Files dropped", files);

            Array.from(files).forEach(file => {
                // Émet l'événement "OnChoosenFile" pour chaque fichier choisi
                this.onChoosenFile(file);

                this.uploadingFiles.push(file);
                console.log("File choosen", file);

                let fileDomElem = "";
                // On va récupérer le template HTML pour chaque fichier
                let xhr = new XMLHttpRequest();
                xhr.open("GET", route("dashboard.ajax.components.media-upload-zone.get-rendered-file-list-component", undefined, undefined, Ziggy));
                xhr.responseType = "text";
                xhr.onload = () => {
                    if (xhr.status === 200) {
                        fileDomElem = xhr.response;
                        fileListElem.innerHTML += fileDomElem;
                    }
                }
                xhr.send();
            });
        }
    }
}

export default MediaUploadZone;
