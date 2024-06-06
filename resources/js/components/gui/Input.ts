type ValidationState = 'valid' | 'invalid' | 'none';

class Input {
    readonly input: HTMLInputElement;
    private readonly parent: HTMLElement;
    private validationState: ValidationState;
    private validFeedbackElement: HTMLElement | null;
    private invalidFeedbackElement: HTMLElement | null;

    constructor(input: HTMLInputElement) {
        this.input = input;
        this.validationState = 'none';
        this.validFeedbackElement = null;
        this.invalidFeedbackElement = null;

        if (input.parentElement === null) {
            console.error('Incompatible input element, parent is null.');
            console.error(input);
            throw new Error('Incompatible input element, parent is null.');
        }

        this.parent = input.parentElement;
        this.checkIfInputAlreadyHasBeenValidated();
    }

    private checkIfInputAlreadyHasBeenValidated(): void {
        let inputIsValid = this.input.classList.contains('is-valid');
        let inputIsInvalid = this.input.classList.contains('is-invalid');
        let validFeedback = this.parent.querySelector('.valid-feedback');
        let invalidFeedback = this.parent.querySelector('.invalid-feedback');

        if (inputIsValid) {
            this.validationState = 'valid';
        }
        if (inputIsInvalid) {
            this.validationState = 'invalid';
        }
        if (validFeedback !== null) {
            this.validFeedbackElement = validFeedback as HTMLElement;
        }
        if (invalidFeedback !== null) {
            this.invalidFeedbackElement = invalidFeedback as HTMLElement;
        }
    }

    /**
     * Set the validation state of the input. If the input has a feedback element, it will be displayed.
     * The other feedback element will be hidden with Bootstrap's d-none class.
     * @param state
     * @param message
     */
    public setValidationState(state: ValidationState, message: string | null): void {
        this.input.classList.remove('is-valid', 'is-invalid');
        if (this.validFeedbackElement) {
            this.validFeedbackElement.classList.add('d-none');
        }
        if (this.invalidFeedbackElement) {
            this.invalidFeedbackElement.classList.add('d-none');
        }

        this.validationState = state;

        if (!this.validFeedbackElement) {
            this.validFeedbackElement = document.createElement('div');
            this.validFeedbackElement.className = 'valid-feedback d-none';
            this.parent.appendChild(this.validFeedbackElement);
        }
        if (!this.invalidFeedbackElement) {
            this.invalidFeedbackElement = document.createElement('div');
            this.invalidFeedbackElement.className = 'invalid-feedback d-none';
            this.parent.appendChild(this.invalidFeedbackElement);
        }

        if (state === 'valid') {
            this.input.classList.add('is-valid');
            if (message) {
                this.validFeedbackElement.textContent = message;
                this.validFeedbackElement.classList.remove('d-none');
            }
        } else if (state === 'invalid') {
            this.input.classList.add('is-invalid');
            if (message) {
                this.invalidFeedbackElement.textContent = message;
                this.invalidFeedbackElement.classList.remove('d-none');
            }
        }
    }

    /**
     * Get the validation state of the input.
     */
    public getValidationState(): ValidationState {
        return this.validationState;
    }

    public getInput(): HTMLInputElement {
        return this.input;
    }
}

export default Input;
