import route from 'ziggy-js';
import {formatBytes} from "../../utils/helpers";

type ToolBoxButtonType = "filter-by-type" | "order" | "view" | "group";
type FileObjectJson = {
    id: number,
    name: string,
    description: string | null,
    filename: string,
    type: string,
    path: string,
    thumbnail_path: string | null,
    size: number,
    created_at: string,
    updated_at: string,
};
type FileObjectsListJson = {
    files: Array<FileObjectJson>,
    total: number,
};

class MediaLibrary {
    private parentElement: HTMLElement;
    private mediaLibraryElement: HTMLElement;
    private files: Array<FileObjectJson> = [];
    private order: string = 'desc';
    private offset: number = 0;
    private filterByType: string = 'all';
    private totalFiles: number = 0;

    private viewLayout: string = 'grid';
    private readonly possibleViewLayouts: Array<string> = ['grid', 'list'];
    private groupBy: string = 'date';
    private readonly possibleGroupBy: Array<string> = ['none', 'date', 'type'];

    private parentContainers: ParentContainer[] = [];
    private csrfToken: string;

    private readonly translationLocale: string = 'en';
    private translation: Object = {
        'all-files': 'All files',
        'images': 'Images',
        'videos': 'Videos',
        'audios': 'Audios',
        'documents': 'Documents',
        'archives': 'Archives',
        'order': {
            'asc': 'Ascending',
            'desc': 'Descending'
        },
        'view': {
            'grid': 'Grid',
            'list': 'List'
        },
        'group': {
            'none': 'None',
            'date': 'Date',
            'type': 'Type'
        }
    };
    private debug: boolean = false;
    public static readonly excludeImagesMimeTypes: Array<string> = [
        'image/vnd.adobe.photoshop'
    ];

    constructor(id: string = 'mediaLibrary') {
        this.csrfToken = this.getCSRFToken();
        this.translationLocale = document.documentElement.lang;
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

        this.addButtonEventListeners("filter-by-type", 'all');
        this.addButtonEventListeners("view", 'grid');
        this.addButtonEventListeners("group", 'date');

        this.getParameters();
    }

    /**
     * Create a button click listener.
     * @param parameterName The name of the parameter to set.
     * @param defaultValue The default value of the parameter.
     * @private
     */
    private createButtonClickListener(parameterName: ToolBoxButtonType, defaultValue: string): (event: Event) => void {
        return (event: Event): void => {
            event.preventDefault();
            const button = event.target as Element;
            const value = button.getAttribute(`data-${parameterName}`) ?? defaultValue;

            if (this[parameterName] !== value) {
                this.setParameter(parameterName, value);
                this.setToolBoxButtonActive(button, parameterName);
            }
        };
    }

    /**
     * Add event listeners to buttons.
     * @param buttonRole The role of the button.
     * @param defaultValue The default value of the parameter.
     * @private
     */
    private addButtonEventListeners(buttonRole: ToolBoxButtonType, defaultValue: string): void {
        const buttons = this.parentElement.querySelectorAll(`button[role="${buttonRole}"]`);
        buttons.forEach((button: Element): void => {
            button.addEventListener('click', this.createButtonClickListener(buttonRole, defaultValue));
        });
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
                this.reRenderFiles();
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

    /**
     * Get the uploaded files from the server.
     * @private
     */
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
                let responseJson: FileObjectsListJson = await response.json() as FileObjectsListJson;
                this.files.push(...responseJson.files);
                this.totalFiles = responseJson.total;

                if (this.debug) console.log(responseJson.files);
                this.reRenderFiles();
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

    /**
     * Change the view layout of the media library.
     * @private
     */
    private changeViewLayout(): void {
        this.mediaLibraryElement.classList.remove('grid', 'list');
        this.mediaLibraryElement.classList.add(this.viewLayout);
    }

    /**
     * Re-render cached files, it doesn't fetch the GetFiles API.
     * @private
     */
    private reRenderFiles(): void {
        if(this.debug) console.log('MediaLibrary: Re-rendering files');
        this.mediaLibraryElement.innerHTML = '';
        this.parentContainers = [];
        this.renderFiles();
    }

    /**
     * Initialize the media library.
     */
    public initialize(): void {
        this.changeViewLayout();
        this.resetFiles();
        this.getFiles();
    }

    /**
     * Render the files in the media library.
     * @param files The files to render.
     * @private
     */
    private renderFiles(files: Array<FileObjectJson> = this.files) {
        if(this.debug) console.log('MediaLibrary: Rendering files');
        if (this.groupBy === 'none') {
            this.renderFilesWithoutGroup(files);
        } else if (this.groupBy === 'date') {
            this.renderFilesGroupedByDate(files);
        }
    }

    private renderFilesWithoutGroup(files: Array<FileObjectJson>) {
        let parentContainer: ParentContainer = new ParentContainer('all', this.translation['all-files']);
        let childContainer: ChildContainer = new ChildContainer();

        for (const file of files) {
            childContainer.addElement(new MediaElement(file));
        }

        parentContainer.children.push(childContainer);
        this.parentContainers.push(parentContainer);

        this.mediaLibraryElement.appendChild(parentContainer.render());
    }

    private renderFilesGroupedByDate(files: Array<FileObjectJson>) {
        let parentContainers: ParentContainer[] = [];

        // Here, parent containers represents the months, and child containers represents the days.
        for (const file of files) {
            let fileDate: Date = new Date(file.created_at);
            let month: string = fileDate.toLocaleString(this.translationLocale, {month: 'long'});
            let year: string = fileDate.getFullYear().toString();
            let day: string = fileDate.getDate().toString();
            let dayOfWeek: string = fileDate.toLocaleString(this.translationLocale, {weekday: 'long'});

            let parentContainer: ParentContainer | undefined = parentContainers.find((parentContainer: ParentContainer): boolean => {
                return parentContainer.identifier === `${month}-${year}`;
            });

            if (parentContainer === undefined) {
                let title: string = month.charAt(0).toUpperCase() + month.slice(1) + ' ' + year;
                parentContainer = new ParentContainer(`${month}-${year}`, title);
                parentContainers.push(parentContainer);
            }

            let childContainer: ChildContainer | undefined = parentContainer.children.find((childContainer: ChildContainer): boolean => {
                return childContainer.identifier === day;
            });

            if (childContainer === undefined) {
                let title: string = dayOfWeek.charAt(0).toUpperCase() + dayOfWeek.slice(1) + ' ' + day;
                childContainer = new ChildContainer(day, title);
                parentContainer.children.push(childContainer);
            }

            let fileMediaElement: MediaElement = new MediaElement(file);
            if(childContainer.hasElement(fileMediaElement)) {
                console.debug(`MediaLibrary: File ${file.id} is already in the media library`);
            }
            childContainer.addElement(fileMediaElement);
        }

        this.parentContainers = parentContainers;
        for (const parentContainer of parentContainers) {
            this.mediaLibraryElement.appendChild(parentContainer.render());
        }
    }

    private getCSRFToken(): string {
        const csrfTokenElem = document.querySelector('meta[name="csrf-token"]');

        const csrfToken = csrfTokenElem?.getAttribute('content') || '';
        if (!csrfToken) {
            console.error("MediaUploadZone: CSRF token not found");
        }
        return csrfToken;
    }

    /**
     * Set a translation. Index are separated by a dot.
     * @param index
     * @param value
     */
    public setTranslation(index: string, value: string): void {
        let translationIndex: string[] = index.split('.');
        let translation: Object = this.translation;
        for (let i = 0; i < translationIndex.length - 1; i++) {
            if (translation[translationIndex[i]] === undefined) {
                translation[translationIndex[i]] = {};
            }
            translation = translation[translationIndex[i]];
        }
        translation[translationIndex[translationIndex.length - 1]] = value;
    }

    public setDebug(debug: boolean): void {
        this.debug = debug;
    }

    public refresh(): void {
        this.resetFiles();
        this.getFiles();
        if(this.debug) console.log('MediaLibrary: Refreshed');
    }
}

class ParentContainer {
    public children: ChildContainer[] = [];
    public readonly identifier: string;
    private readonly containerTitle: string;

    constructor(identifier: string, title: string = '') {
        this.identifier = identifier;
        this.containerTitle = identifier;
        if (title !== '') {
            this.containerTitle = title;
        }
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
    private mediaElements: MediaElement[] = [];
    public readonly identifier: string | null;
    private readonly containerTitle: string | null;

    constructor(identifier: string | null = null, title: string | null = null) {
        this.containerTitle = title;
        this.identifier = title;
        if (identifier !== null) {
            this.identifier = identifier;
        }
    }

    addElement(element: MediaElement): void {
        this.mediaElements.push(element);
    }

    hasElement(element: MediaElement): boolean {
        return this.mediaElements.includes(element);
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

        for (const element of this.mediaElements) {
            containerDiv.appendChild(element.getElement());
        }

        return container;
    }
}

class MediaElement {
    private readonly element: HTMLElement;
    private readonly fileObject: FileObjectJson;
    public static fileTypeIcons: FileTypeIcon[] = [];

    constructor(fileObject: FileObjectJson) {
        this.fileObject = fileObject;
        this.element = this.render();
    }

    private render(): HTMLElement {
        let fileType: string = this.fileObject.type.split('/')[0];

        if (fileType === 'image' && !MediaLibrary.excludeImagesMimeTypes.includes(this.fileObject.type)) {
            return this.renderImageDomElement();
        }
        return this.renderFileDomElement();
    }

    public getElement(): HTMLElement {
        return this.element;
    }

    /**
     * This method creates the base dom element of a file, whether it's an image or not.
     * @private
     */
    private renderBaseDomElement(): HTMLElement {
        /* File element model
        <div class="media-element type-media/type-file">
            <div class="meta">
                <div class="icon"><i class="fa-solid fa-file-pdf"></i></div>
                <div class="name">RandomFile.pdf</div>
                <div class="size">1.2 MB</div>
            </div>
        </div>*/

        let mediaRootElement: HTMLElement = document.createElement('div');
        mediaRootElement.className = 'media-element';
        mediaRootElement.setAttribute('data-file-id', String(this.fileObject.id));
        mediaRootElement.setAttribute('data-file-mime-type', this.fileObject.type);

        let metaElement: HTMLElement = document.createElement('div');
        metaElement.className = 'meta';
        mediaRootElement.appendChild(metaElement);

        let iconContainerElement: HTMLElement = document.createElement('div');
        iconContainerElement.className = 'icon';

        let iconElement: HTMLElement = document.createElement('i');
        iconElement.className = 'fa-solid fa-file';

        this.getFileTypeIcon(this.fileObject.type).then((iconClassName: string) => {
            iconElement.className = iconClassName;
        });

        iconContainerElement.appendChild(iconElement);
        metaElement.appendChild(iconContainerElement);

        let nameElement: HTMLElement = document.createElement('div');
        nameElement.className = 'name';
        nameElement.textContent = this.fileObject.name;
        nameElement.setAttribute('title', this.fileObject.name);
        metaElement.appendChild(nameElement);

        let sizeElement: HTMLElement = document.createElement('div');
        sizeElement.className = 'size';
        sizeElement.textContent = formatBytes(this.fileObject.size);
        metaElement.appendChild(sizeElement);

        return mediaRootElement;
    }

    /**
     * Render an image media element.
     * @private
     */
    private renderImageDomElement(): HTMLElement {
        let baseDomElement: HTMLElement = this.renderBaseDomElement();

        let filePath: string = this.fileObject.path;
        if (this.fileObject.thumbnail_path !== null) {
            filePath = this.fileObject.thumbnail_path;
        }

        let fileUrl: string = route('showcase.storage', {path: filePath})

        baseDomElement.classList.add('type-image');
        let iconElement: HTMLElement = baseDomElement.querySelector('.icon') as HTMLElement;
        iconElement.innerHTML = '';
        iconElement.style.backgroundImage = `url(${fileUrl})`;

        return baseDomElement;
    }

    /**
     * Render a file media element.
     * @private
     */
    private renderFileDomElement(): HTMLElement {
        let baseDomElement: HTMLElement = this.renderBaseDomElement();
        baseDomElement.classList.add('type-file');

        return baseDomElement;
    }

    /**
     * Get the icon class name of a file type.
     * @param type The type of the file.
     * @private
     */
    private async getFileTypeIcon(type: string): Promise<string> {
        let icon = "";
        for (const fileTypeIcon of MediaElement.fileTypeIcons) {
            if (fileTypeIcon.type === type) {
                icon = await fileTypeIcon.getIcon();
            }
        }

        if (icon === "") {
            const fileTypeIcon: FileTypeIcon = new FileTypeIcon(type);
            MediaElement.fileTypeIcons.push(fileTypeIcon);
            icon = await fileTypeIcon.getIcon();
        }

        return icon;
    }
}

class FileTypeIcon {
    public readonly type: string;
    private iconClassName: string | null = null;
    private readonly promise: Promise<void> | null = null;

    constructor(type: string) {
        this.type = type;
        this.promise = fetch(route("dashboard.ajax.components.media-upload-zone.find-icon", {type: encodeURI(this.type)}), {
            method: "GET",
            headers: {
                'Accept': 'application/json',
            },
        })
            .then(async (response: Response): Promise<void> => {
                if (!response.ok) {
                    throw new Error(response.statusText);
                }

                const responseJson = await response.json();
                this.iconClassName = responseJson.icon;
            })
            .catch((error): void => {
                console.error(error);
            });
    }

    async getIcon(): Promise<string> {
        if (this.iconClassName === null) {
            await this.promise;
        }
        return this.iconClassName ?? 'fa-solid fa-file';
    }
}

export default MediaLibrary;