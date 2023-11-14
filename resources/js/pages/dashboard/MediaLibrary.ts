class MediaLibrary {
    parentElement: HTMLElement | null;

    constructor(id = 'mediaLibrary') {
        this.parentElement = document.getElementById(id);
        if (this.parentElement === null) {
            console.error("MediaLibrary: Parent element not found");
            return;
        }
        console.log("MediaLibrary: Parent element found");
    }
}

export default MediaLibrary;
