import route from 'ziggy-js';

class MediaLibrary {
    private parentElement: HTMLElement;
    private mediaLibraryElement: HTMLElement;
    private files: Array<Object> = [];
    private order: string = 'desc';
    private offset: number = 0;
    private filterByType: string = 'all';
    private totalFiles: number = 0;

    private filterButtons: NodeListOf<Element>;
    private viewButtons: NodeListOf<Element>;
    private view: string = 'grid';
    private possibleViewLayouts: Array<string> = ['grid', 'list'];

    constructor(id: string = 'mediaLibrary') {
        let parentElement: HTMLElement | null = document.getElementById(id);
        if (parentElement === null) {
            throw new Error("MediaLibrary: Parent element not found");
        }
        this.parentElement = parentElement;

        let mediaLibraryElement: HTMLElement | null = document.getElementById('mediaLibraryMedias');
        if (mediaLibraryElement === null) {
            throw new Error("MediaLibrary: Media library element not found");
        }
        this.mediaLibraryElement = mediaLibraryElement;

        this.filterButtons = this.parentElement.querySelectorAll('button[role="filter-by-type"]');

        this.filterButtons.forEach((button: Element): void => {
            button.addEventListener('click', (event: Event): void => {
                event.preventDefault();
                let filterByType: string = button.getAttribute('data-filter-by-type') ?? 'all';

                if (this.filterByType !== filterByType) {
                    this.setParameter('filter-by-type', filterByType);
                    this.setToolBoxButtonActive(button, "filter-by-type");
                }
            });
        });

        this.viewButtons = this.parentElement.querySelectorAll('button[role="view"]');

        this.viewButtons.forEach((button: Element): void => {
            button.addEventListener('click', (event: Event): void => {
                event.preventDefault();
                let view: string = button.getAttribute('data-view') ?? 'grid';

                if (this.view !== view) {
                    this.setParameter('view', view);
                    this.setToolBoxButtonActive(button, "view");
                }
            });
        });

        this.getParameters();
        this.initialize();
        this.getFiles();
    }

    /**
     * Reset the files array and the offset.
     * @private
     */
    private resetFiles(): void {
        this.files = [];
        this.offset = 0;
        this.totalFiles = 0;
    }

    /**
     * Set a parameter in the url and in the class.
     * @param role The role of the parameter (based on the button role).
     * @param value The value of the parameter.
     * @private
     */
    private setParameter(role: string, value: string): void {
        switch (role) {
            case 'order':
                this.order = value;
                this.resetFiles();
                this.getFiles();
                break;
            case 'filter-by-type':
                this.filterByType = value;
                this.resetFiles();
                this.getFiles();
                break;
            case 'view':
                this.view = value;
                this.changeViewLayout();
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
    private getParameters(): void {
        let url: URL = new URL(window.location.href);
        let searchParams: URLSearchParams = url.searchParams;

        if (searchParams.has('order')) {
            this.order = searchParams.get('order') ?? 'desc';
        }

        if (searchParams.has('filter-by-type')) {
            this.filterByType = searchParams.get('filter-by-type') ?? 'all';
        }

        if (searchParams.has('view')) {
            let view: string = searchParams.get('view') ?? 'grid';
            this.view = 'grid';
            if (this.possibleViewLayouts.includes(view)) {
                this.view = view;
            }
        }

        let correspondingFilterByTypeButton = this.parentElement.querySelector(`button[role="filter-by-type"][data-filter-by-type="${this.filterByType}"]`);
        if (correspondingFilterByTypeButton !== null) {
            this.setToolBoxButtonActive(correspondingFilterByTypeButton, "filter-by-type");
        }

        let correspondingOrderByButton = this.parentElement.querySelector(`button[role="order"][data-order="${this.order}"]`);
        if (correspondingOrderByButton !== null) {
            this.setToolBoxButtonActive(correspondingOrderByButton, "order");
        }

        let correspondingViewButton = this.parentElement.querySelector(`button[role="view"][data-view="${this.view}"]`);
        if (correspondingViewButton !== null) {
            this.setToolBoxButtonActive(correspondingViewButton, "view");
        }
    }

    private getFiles(): void {
        let url = route('dashboard.media-library.get-uploaded-files', {order: this.order, offset: this.offset, type: this.filterByType});
        fetch(url, {
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
            })
            .catch((error) => {
                console.error(error);
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

    private changeViewLayout() {
        this.mediaLibraryElement.classList.remove('grid', 'list');
        this.mediaLibraryElement.classList.add(this.view);
    }

    private initialize() {
        this.changeViewLayout();
        this.resetFiles();
        this.getFiles();
    }
}

export default MediaLibrary;
