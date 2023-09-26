class MediaUploadZone {
    parentElement;

    constructor(id="mediaUploadZone") {
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
        const event = new CustomEvent("OnChoosenFile", { detail: file });
        this.parentElement.dispatchEvent(event);
    }

    onFileUploaded(file) {
        const event = new CustomEvent("OnFileUploaded", { detail: file });
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
            // Gère chaque fichier ici
            files.forEach((file) => {
                // Émet l'événement "OnChoosenFile" pour chaque fichier choisi
                this.onChoosenFile(file);

                // Ensuite, tu peux implémenter la logique d'envoi du fichier vers ton API
                // Une fois que l'envoi est terminé, émet l'événement "OnFileUploaded"
                // pour indiquer que le fichier a été téléchargé avec succès.
                // N'oublie pas de gérer le cas où tous les fichiers sont téléchargés
            });
        }
    }
}
export default MediaUploadZone;
