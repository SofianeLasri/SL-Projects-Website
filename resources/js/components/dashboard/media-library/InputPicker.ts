import {Modal} from 'bootstrap';
import MediaLibrary from "./MediaLibrary";

type Apparence = 'input' | 'square';

class InputPicker {
    private readonly input: HTMLInputElement;
    private readonly modal: Modal;
    private readonly apparence: Apparence;
    private elementToListen: HTMLElement;
    private embeddedMediaLibrary: MediaLibrary;

    constructor(container: HTMLElement) {
        this.apparence = container.classList.contains('square') ? 'square' : 'input';

        if (this.apparence === 'input') {
            this.elementToListen = container.querySelector('input') as HTMLElement;
        } else {
            this.elementToListen = container;
        }

        let targetId: string = container.dataset.targetId!;
        this.input = document.getElementById(targetId) as HTMLInputElement;

        this.modal = new Modal("#mediaPickerModal", {
            keyboard: false,
            backdrop: 'static'
        });

        let maxFileCount: number = parseInt(container.dataset.fileCount!);

        this.embeddedMediaLibrary = new MediaLibrary('mediaPickerModal', 'selection');
        this.embeddedMediaLibrary.setSelectionOperationModeMaxFiles(maxFileCount);

        this.init();
    }

    private init() {
        this.embeddedMediaLibrary.initialize();
        this.elementToListen.addEventListener('click', () => {
            this.openPicker();
        });
    }

    private openPicker() {
        console.log('open picker');
        this.modal.show();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const inputPickers: NodeListOf<Element> = document.querySelectorAll('.media-picker');
    inputPickers.forEach((inputPicker: Element) => {
        new InputPicker(inputPicker as HTMLElement);
    });
});
