@props([
    'id' => '',
    'name' => '',
    'type' => 'text',
    'data-form-type' => '',
    'placeholder' => '',
    'label' => '',
    'value' => '',
    'required' => false,
    'apparence' => 'combined',
    'class' => '',
    'validation' => 'none',
    'feedback' => '',
])

@php
    if(!in_array($type, ['text', 'password', 'email', 'number', 'tel', 'url', 'search', 'date', 'time', 'datetime-local', 'month', 'week', 'color', 'range', 'file', 'hidden'])) {
        throw \Illuminate\Validation\ValidationException::withMessages(
            [
                'type' => "Input type '$type' is incorrect. Possible types are 'text', 'password', 'email', 'number', 'tel', 'url', 'search', 'date', 'time', 'datetime-local', 'month', 'week', 'color', 'range', 'file', 'hidden'."
            ]
        );
    }

    // https://dashlane.github.io/SAWF/#mozTocId902224
    if(!empty($dataFormType)) {
        if(!in_array($dataFormType, ['action', 'address', 'age', 'company', 'consent', 'date', 'email', 'id_document', 'name', 'other', 'otp', 'password', 'payment', 'phone', 'query', 'title', 'username', 'website'])) {
            throw \Illuminate\Validation\ValidationException::withMessages(
                [
                    'data_form_type' => "Input data-form-type '$dataFormType' is incorrect. Possible types are 'action', 'address', 'age', 'company', 'consent', 'date', 'email', 'id_document', 'name', 'other', 'otp', 'password', 'payment', 'phone', 'query', 'title', 'username', 'website'."
                ]
            );
        }
    } else {
        $dataFormType = '';
    }

    if(!in_array($apparence, ['combined', 'separated'])) {
        throw \Illuminate\Validation\ValidationException::withMessages(
            [
                'apparence' => "Input apparence '$apparence' is incorrect. Possible types are 'combined' and 'separated'."
            ]
        );
    }

    if(!in_array($validation, ['none', 'invalid', 'valid'])) {
        throw \Illuminate\Validation\ValidationException::withMessages(
            [
                'validation' => "Input validation '$validation' is incorrect. Possible types are 'none', 'invalid' and 'valid'."
            ]
        );
    }

    $id = !empty($id) ? $id : 'input_' . $name;
    $required = $required ? 'required' : '';
    $label = !empty($label) ? $label : $name;
    $value = !empty($value) ? $value : old($name);

    if($validation === 'invalid') {
        $class .= ' is-invalid';
    } elseif($validation === 'valid') {
        $class .= ' is-valid';
    }
@endphp

@if($apparence === "combined")
    <fieldset class="input-fieldset {{ $class }}" data-validation="{{ $validation }}">
        @if($type === "password")
            <span class="input-span is-password">
                <span class="input-span">
                    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
                           data-form-type="{{ $dataFormType }}" value="{{ $value }}"
                           class="input-field" {{ $required }} placeholder="{{ html_entity_decode($placeholder) }}">
                    <label class="input-label" for="{{ $id }}">
                        <span>{{ html_entity_decode($label) }}</span>
                    </label>
                </span>
                <button class="password-reveal" type="button" data-toggle="password" data-target="#{{ $id }}">
                    <i class="fa-regular fa-eye"></i>
                </button>
            </span>

            <div class="feedback{{ empty($feedback) ? ' d-none' : '' }}">
                {{ html_entity_decode($feedback ?? '') }}
            </div>
        @else
            <span class="input-span">
                <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
                       data-form-type="{{ $dataFormType }}" value="{{ $value }}"
                       class="input-field" {{ $required }} placeholder="{{ html_entity_decode($placeholder) }}">
                <label class="input-label" for="{{ $id }}">
                    <span>{{ html_entity_decode($label) }}</span>
                </label>
            </span>

            <div class="feedback{{ empty($feedback) ? ' d-none' : '' }}">
                {{ html_entity_decode($feedback ?? '') }}
            </div>
        @endif
    </fieldset>

    @pushonce('scripts')
        <script type="text/javascript">
            class Input {
                fieldset;
                input;
                validation;
                feedbackElement;

                constructor(input) {
                    this.input = input
                    this.fieldset = input.closest('.input-fieldset');
                    this.validation = this.fieldset.dataset.validation;
                    this.feedbackElement = this.fieldset.querySelector('.feedback');
                    this.init();
                }

                init() {
                    // On intialise l'input
                    this.input.addEventListener('focus', event => {
                        this.input.parentNode.classList.add('has-value');
                    });

                    this.input.addEventListener('blur', event => {
                        // On vérifie si l'input a une valeur
                        if (event.target.value) {
                            // On ajoute la classe "has-value" au parent du parent de l'input
                            event.target.parentNode.classList.add('has-value');
                        } else {
                            // On retire la classe "has-value" au parent du parent de l'input
                            event.target.parentNode.classList.remove('has-value');
                        }
                    });

                    if (this.input.value) {
                        this.input.parentNode.classList.add('has-value');
                    }

                    // Maintenant on regarde ses particularités
                    const dataFormType = this.input.dataset.formType;

                    if (dataFormType === 'password') {
                        this.initPassword();
                    }
                }

                initPassword() {
                    const passwordReveal = this.fieldset.querySelector('.password-reveal');
                    passwordReveal.addEventListener('click', event => {
                        const input = event.currentTarget.dataset.target;
                        const inputElement = document.querySelector(input);
                        const icon = event.currentTarget.firstElementChild;

                        if (inputElement.type === 'password') {
                            inputElement.type = 'text';
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            inputElement.type = 'password';
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    });
                }

                updateValidationState(validation, feedback) {
                    this.validation = validation;
                    this.fieldset.classList.remove('is-valid', 'is-invalid');

                    if(this.validation === 'valid') {
                        this.fieldset.classList.add('is-valid');
                    } else if(this.validation === 'invalid') {
                        this.fieldset.classList.add('is-invalid');
                    }

                    if(feedback === '' || feedback === undefined) {
                        this.feedbackElement.classList.add('d-none');
                    } else {
                        this.feedbackElement.classList.remove('d-none');
                        this.feedbackElement.innerHTML = feedback;
                    }
                }

                validate(feedback) {
                    this.updateValidationState('valid', feedback);
                }

                invalidate(feedback) {
                    this.updateValidationState('invalid', feedback);
                }

                removeValidation() {
                    this.updateValidationState('none');
                }
            }

            document.addEventListener("DOMContentLoaded", (event) => {
                const fieldsets = document.querySelectorAll('.input-fieldset');

                fieldsets.forEach(fieldset => {
                    new Input(fieldset);
                });
            });
        </script>
    @endpushonce
@else
    <div class="d-flex flex-column {{ $class }}">
        <label for="{{ $id }}" class="form-label">{{ html_entity_decode($label) }}</label>
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
               placeholder="{{ $placeholder }}"
               data-form-type="{{ $dataFormType }}" value="{{ $value }}"
               class="form-control" {{ $required }}>
    </div>
@endif
