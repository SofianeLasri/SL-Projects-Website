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

        this.embeddedMediaLibrary = new MediaLibrary('mediaPickerModal', 'embeded-selection');
        this.embeddedMediaLibrary.setSelectionOperationModeMaxFiles(this.maxFileCount);

        this.init();
    }

    private init() {
        this.embeddedMediaLibrary.initialize();
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
        let selectedMedia: FileObjectJson[] = this.embeddedMediaLibrary.getSelectedFiles();
        if (selectedMedia.length > 0) {
            if (this.apparence === 'input') {
                this.input.value = selectedMedia.map((file: FileObjectJson) => file.id).join(',');
                this.fakeInput.value = selectedMedia.map((file: FileObjectJson) => file.name).join(',');
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
