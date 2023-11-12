class MediaLibrary {
    parentElement;

    constructor(id = 'mediaLibrary') {
        this.parentElement = document.getElementById(id);
        if (this.parentElement === null) {
            console.error("MediaLibrary: Parent element not found");
            return;
        }
    }
}

export default MediaLibrary;
