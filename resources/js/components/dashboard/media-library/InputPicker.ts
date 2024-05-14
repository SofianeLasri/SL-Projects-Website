type Apparence = 'input' | 'square';

class InputPicker {
    private id: string;
    private input: HTMLInputElement;
    private apparence: Apparence;
    private parentElement: HTMLElement;

    constructor(id: string, apparence: Apparence) {
        this.id = id;
        this.input = document.getElementById(id) as HTMLInputElement;
        this.apparence = apparence;

        if (this.apparence === 'input') {
            this.parentElement = this.input as HTMLElement;
        } else {
            this.parentElement = this.input.parentElement as HTMLElement;
        }

        this.init();
    }

    private init() {
        this.parentElement.addEventListener('click', () => {
            this.openPicker();
        });
    }

    private openPicker() {
        console.log('open picker');
    }
}
