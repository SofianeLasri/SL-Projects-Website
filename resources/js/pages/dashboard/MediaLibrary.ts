import route from 'ziggy-js';

type ToolBoxButtonType = "filter-by-type" | "order" | "view" | "group";

class MediaLibrary {
    private parentElement: HTMLElement;
    private mediaLibraryElement: HTMLElement;
    private files: Array<Object> = [];
    private order: string = 'desc';
    private offset: number = 0;
    private filterByType: string = 'all';
    private totalFiles: number = 0;

    private filterButtons: NodeListOf<Element>;
    private viewLayoutButtons: NodeListOf<Element>;
    private viewLayout: string = 'grid';
    private readonly possibleViewLayouts: Array<string> = ['grid', 'list'];
    private groupBy: string = 'date';
    private groupByButtons: NodeListOf<Element>;
    private readonly possibleGroupBy: Array<string> = ['none', 'date', 'type'];

    private parentContainers: ParentContainer[] = [];

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

        this.viewLayoutButtons = this.parentElement.querySelectorAll('button[role="view"]');

        this.viewLayoutButtons.forEach((button: Element): void => {
            button.addEventListener('click', (event: Event): void => {
                event.preventDefault();
                let view: string = button.getAttribute('data-view') ?? 'grid';

                if (this.viewLayout !== view) {
                    this.setParameter('view', view);
                    this.setToolBoxButtonActive(button, "view");
                }
            });
        });

        this.groupByButtons = this.parentElement.querySelectorAll('button[role="group"]');

        this.groupByButtons.forEach((button: Element): void => {
            button.addEventListener('click', (event: Event): void => {
                event.preventDefault();
                let groupBy: string = button.getAttribute('data-group') ?? 'date';

                if (this.groupBy !== groupBy) {
                    this.setParameter('group', groupBy);
                    this.setToolBoxButtonActive(button, "group");
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
                this.viewLayout = value;
                this.changeViewLayout();
                break;
            case 'group':
                this.groupBy = value;
                this.changeGroupBy();
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
            this.viewLayout = 'grid';
            if (this.possibleViewLayouts.includes(view)) {
                this.viewLayout = view;
            }
        }

        if (searchParams.has('group')) {
            let group: string = searchParams.get('group') ?? 'date';
            this.groupBy = 'date';
            if (this.possibleGroupBy.includes(group)) {
                this.groupBy = group;
            }
        }

        this.findAndActivateButton("filter-by-type", this.filterByType);
        this.findAndActivateButton("order", this.order);
        this.findAndActivateButton("view", this.viewLayout);
        this.findAndActivateButton("group", this.groupBy);
    }

    /**
     * Find and activate a button based on its role and its data value.
     * @param type The role of the button.
     * @param dataValue The data value of the button.
     * @private
     */
    private findAndActivateButton(type: ToolBoxButtonType, dataValue: string): void {
        const correspondingButton: Element | null = this.parentElement.querySelector(`button[role="${type}"][data-${type}="${dataValue}"]`);

        if (correspondingButton !== null) {
            this.setToolBoxButtonActive(correspondingButton, type);
        }
    }

    private getFiles(): void {
        let url: string = route('dashboard.media-library.get-uploaded-files', {
            order: this.order,
            offset: this.offset,
            type: this.filterByType
        });
        fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
            },
        })
            .then(async (response: Response): Promise<void> => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }
                let responseJson = await response.json();
                this.files.push(...responseJson.files);
                this.totalFiles = responseJson.total;

                this.renderFiles(responseJson.files);
            })
            .catch((error): void => {
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

    private changeViewLayout(): void {
        this.mediaLibraryElement.classList.remove('grid', 'list');
        this.mediaLibraryElement.classList.add(this.viewLayout);
    }

    private changeGroupBy(): void {

    }

    private initialize(): void {
        this.changeViewLayout();
        this.resetFiles();
        this.getFiles();
    }

    /**
     * Render the files in the media library.
     * @param files The files to render.
     * @private
     */
    private renderFiles(files: Object = this.files) {
        if(this.groupBy === 'none') {
            this.renderFilesWithoutGroup(files);
        }
    }

    private renderFilesWithoutGroup(files: Object) {

    }
}

class ParentContainer {
    private children: ChildContainer[] = [];
    private readonly containerTitle: string;

    constructor(title: string) {
        this.containerTitle = title;
    }

    addChild(child: ChildContainer): void {
        this.children.push(child);
    }

    render(): HTMLElement {
        const container = document.createElement('div');
        container.className = 'parent-section';

        const titleElement = document.createElement('h4');
        titleElement.textContent = this.containerTitle;
        container.appendChild(titleElement);

        const containerDiv = document.createElement('div');
        containerDiv.className = 'parent-section-container';
        container.appendChild(containerDiv);

        for (const child of this.children) {
            containerDiv.appendChild(child.render());
        }

        return container;
    }
}

class ChildContainer {
    private elements: HTMLElement[] = [];
    private readonly containerTitle: string | null;

    constructor(title: string | null = null) {
        this.containerTitle = title;
    }

    addElement(element: HTMLElement): void {
        this.elements.push(element);
    }

    render(): HTMLElement {
        const container = document.createElement('div');
        container.className = 'section';

        if (this.containerTitle !== null) {
            const titleElement = document.createElement('h6');
            titleElement.textContent = this.containerTitle;
            container.appendChild(titleElement);
        }

        const containerDiv = document.createElement('div');
        containerDiv.className = 'section-container';
        container.appendChild(containerDiv);

        for (const element of this.elements) {
            containerDiv.appendChild(element);
        }

        return container;
    }
}

export default MediaLibrary;
