import {Modal} from 'bootstrap';
import MediaLibrary, {FileObjectJson} from "./MediaLibrary";

type Apparence = 'input' | 'square';

class InputPicker {
    private readonly input: HTMLInputElement;
    private readonly fakeInput: HTMLInputElement; // For visual purpose only
    private readonly modalId: string = 'mediaPickerModal';
    private readonly modal: Modal;
    private readonly apparence: Apparence;
    private elementToListen: HTMLElement;
    private embeddedMediaLibrary: MediaLibrary;
    private readonly confirmButton: HTMLButtonElement;
    private readonly maxFileCount: number;
    private selectedFilesId: number[] = [];

    constructor(container: HTMLElement) {
        this.apparence = container.classList.contains('square') ? 'square' : 'input';

        if (this.apparence === 'input') {
            this.elementToListen = container.querySelector('input') as HTMLElement;
        } else {
            this.elementToListen = container;
        }

        let targetId: string = container.dataset.targetId!;
        this.input = document.getElementById(targetId) as HTMLInputElement;
        this.fakeInput = document.getElementById(targetId + "_fake") as HTMLInputElement;

        let modalElement: Element = document.getElementById(this.modalId)!;
        this.modal = new Modal(modalElement);
        this.confirmButton = modalElement.querySelector('.modal-footer .btn-primary') as HTMLButtonElement;

        this.maxFileCount = parseInt(container.dataset.fileCount!);
        let selectedFiles: string = container.dataset.selectedFiles!; // Only list of numbers
        this.selectedFilesId = selectedFiles.split(',').map((id: string) => parseInt(id));
        console.log("Selected files: ", this.selectedFilesId);

        this.embeddedMediaLibrary = new MediaLibrary('mediaPickerModal', 'embeded-selection');
        this.embeddedMediaLibrary.setSelectionOperationModeMaxFiles(this.maxFileCount);

        this.init();
    }

    private init() {
        this.embeddedMediaLibrary.initialize().then(() => {
            this.embeddedMediaLibrary.setSelectedFiles(this.selectedFilesId);
        });
        this.elementToListen.addEventListener('click', () => {
            this.openPicker();
        });
        this.confirmButton.addEventListener('click', () => {
            this.confirmSelection();
        });
    }

    private openPicker() {
        console.log('open picker');
        this.modal.show();
    }

    private confirmSelection() {
        console.log('confirm selection');
        let selectedMedias: FileObjectJson[] = this.embeddedMediaLibrary.getSelectedFiles();
        this.selectedFilesId = selectedMedias.map((file: FileObjectJson) => file.id);

        if (selectedMedias.length > 0) {
            if (this.apparence === 'input') {
                this.input.value = selectedMedias.map((file: FileObjectJson) => file.id).join(',');
                this.fakeInput.value = selectedMedias.map((file: FileObjectJson) => file.name).join(',');
            } else {
                // TODO: Do the code for square apparence
            }
            this.modal.hide();
        } else {
            // TODO: Alert
            console.log('No file selected');
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const inputPickers: NodeListOf<Element> = document.querySelectorAll('.media-picker');
    inputPickers.forEach((inputPicker: Element) => {
        new InputPicker(inputPicker as HTMLElement);
    });
});
