@props([
    'id' => '',
    'name' => '',
    'placeholder' => '',
    'label' => '',
    'value' => '',
    'required' => false,
    'class' => '',
    'rows' => 4, // Nombres de lignes pour le textarea
])

@php
    $id = !empty($id) ? $id : 'textarea_' . $name;
    $required = $required ? 'required' : '';
    $label = !empty($label) ? $label : $name;
    $value = !empty($value) ? $value : old($name);
@endphp

<fieldset class="textarea-fieldset {{ $class }}">
    <span class="textarea-span">
        <textarea name="{{ $name }}" id="{{ $id }}" rows="{{ $rows }}"
                  class="textarea-field"
                  {{ $required }} placeholder="{{ html_entity_decode($placeholder) }}">{{ $value }}</textarea>
        <label class="textarea-label" for="{{ $id }}">
            <span>{{ html_entity_decode($label) }}</span>
        </label>
    </span>
</fieldset>

@pushonce('scripts')
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", (event) => {
            const fieldsets = document.querySelectorAll('.textarea-fieldset');

            fieldsets.forEach(fieldset => {
                const input = fieldset.querySelector('.textarea-field');

                input.addEventListener('focus', event => {
                    input.parentNode.classList.add('has-value');
                });

                input.addEventListener('blur', event => {
                    // On vérifie si l'input a une valeur
                    if (event.target.value) {
                        // On ajoute la classe "has-value" au parent du parent de l'input
                        event.target.parentNode.classList.add('has-value');
                    } else {
                        // On retire la classe "has-value" au parent du parent de l'input
                        event.target.parentNode.classList.remove('has-value');
                    }
                });

                if (input.value) {
                    input.parentNode.classList.add('has-value');
                }
            });
        });

    </script>
@endpushonce
