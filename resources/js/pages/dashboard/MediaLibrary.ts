import route from 'ziggy-js';
class MediaLibrary {
    protected parentElement: HTMLElement;
    private files: Array<Object> = [];
    private order: string = 'desc';
    private offset: number = 0;
    private filterByType: string = 'all';

    constructor(id = 'mediaLibrary') {
        let parentElement = document.getElementById(id);
        if (parentElement === null) {
            throw new Error("MediaLibrary: Parent element not found");
        } else {
            this.parentElement = parentElement;
        }

        this.getFiles();
    }

    private getFiles(): void {
        let url = route('dashboard.media-library.get-uploaded-files', {order: this.order, offset: this.offset, type: this.filterByType});
        const fetchPromise = fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        })
            .then(async (response) => {
                if(!response.ok) {
                    throw new Error(response.statusText);
                }
                let responseJson = await response.json();
                this.files.push(...responseJson.files);

                for (let file of this.files) {
                    console.log(file);
                    // TODO: Faire la suite quoi (afficher les fichiers)
                }
            });
    }
}

export default MediaLibrary;
