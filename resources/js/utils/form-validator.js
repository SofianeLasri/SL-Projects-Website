class FormValidator {
    /**
     * Create a new FormValidator instance.
     * @param fieldNames An array of field names to validate.
     */
    constructor(fieldNames) {
        this.fields = new Map();
        this.validatedCallback = null;
        this.invalidatedCallback = null;

        for (const fieldName of fieldNames) {
            this.fields.set(fieldName, false);
        }
    }

    /**
     * Change the validation state of a field.
     * @param fieldName
     * @param validate If true, the form will be validated if all fields are valid.
     */
    changeField(fieldName, validate = false) {
        if (this.fields.has(fieldName)) {
            this.fields.set(fieldName, validate);
            this.checkValidation();
        }
    }

    /**
     * Define a callback to be called when the form is validated.
     * @param callback
     */
    onValidated(callback) {
        this.validatedCallback = callback;
    }

    /**
     * Define a callback to be called when the form is invalidated.
     * @param callback
     */
    onInvalidated(callback) {
        this.invalidatedCallback = callback;
    }

    checkValidation() {
        const allValid = [...this.fields.values()].every(field => field === true);

        if (allValid && this.validatedCallback) {
            this.validatedCallback();
        } else if (!allValid && this.invalidatedCallback) {
            this.invalidatedCallback();
        }
    }
}

export default FormValidator;
