import route from 'ziggy-js';
import {Obj} from "@popperjs/core";

class MediaLibrary {
    protected parentElement: HTMLElement;
    private files: Array<Object> = [];
    private order: string = 'desc';
    private offset: number = 0;
    private filterByType: string = 'all';
    private totalFiles: number = 0;

    private filterButtons: NodeListOf<Element>;

    constructor(id = 'mediaLibrary') {
        let parentElement = document.getElementById(id);
        if (parentElement === null) {
            throw new Error("MediaLibrary: Parent element not found");
        } else {
            this.parentElement = parentElement;
        }

        this.filterButtons = this.parentElement.querySelectorAll('button[role="filter-by-type"]');

        this.filterButtons.forEach((button) => {
            button.addEventListener('click', (event) => {
                event.preventDefault();
                let filterByType = button.getAttribute('data-filter-by-type') ?? 'all';

                if (this.filterByType !== filterByType) {
                    this.setParameter('filter-by-type', filterByType);
                    this.setToolBoxButtonActive(button, "filter-by-type");
                    this.resetFiles();
                    this.getFiles();
                }
            });
        });

        this.getParameters();
        this.getFiles();
    }

    /**
     * Reset the files array and the offset.
     * @private
     */
    private resetFiles() {
        this.files = [];
        this.offset = 0;
        this.totalFiles = 0;
    }

    private setParameter(role: string, value: string): void {
        switch (role) {
            case 'order':
                this.order = value;
                break;
            case 'filter-by-type':
                this.filterByType = value;
                break;
        }

        let url: URL = new URL(window.location.href);
        let searchParams: URLSearchParams = url.searchParams;
        searchParams.set(role, value);
        url.search = searchParams.toString();
        window.history.pushState({}, '', url.toString());
    }

    /**
     * Get the filters from the url
     * @private
     */
    private getParameters() {
        let url: URL = new URL(window.location.href);
        let searchParams: URLSearchParams = url.searchParams;

        if (searchParams.has('order')) {
            this.order = searchParams.get('order') ?? 'desc';
        }

        if (searchParams.has('filter-by-type')) {
            this.filterByType = searchParams.get('filter-by-type') ?? 'all';
        }

        let correspondingFilterByTypeButton = this.parentElement.querySelector(`button[role="filter-by-type"][data-filter-by-type="${this.filterByType}"]`);
        if (correspondingFilterByTypeButton !== null) {
            this.setToolBoxButtonActive(correspondingFilterByTypeButton, "filter-by-type");
        }

        let correspondingOrderByButton = this.parentElement.querySelector(`button[role="order"][data-order="${this.order}"]`);
        if (correspondingOrderByButton !== null) {
            this.setToolBoxButtonActive(correspondingOrderByButton, "order");
        }
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
                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                let responseJson = await response.json();
                this.files.push(...responseJson.files);
                this.totalFiles = responseJson.total;

                for (let file of this.files) {
                    console.log(file);
                    // TODO: Faire la suite quoi (afficher les fichiers)
                }
            });
    }

    /**
     * Set the active state of a toolbox button.
     * @param button The button to set active.
     * @param role The role of the button.
     * @private
     */
    private setToolBoxButtonActive(button: Element, role: string): void {
        this.parentElement.querySelectorAll(`button[role="${role}"]`).forEach((button: Element): void => {
            button.classList.remove('active');
            button.setAttribute('aria-selected', 'false');
        });
        button.classList.add('active');
        button.setAttribute('aria-selected', 'true');
    }

    private createFileObject(file: Object): void {

    }
}

export default MediaLibrary;
