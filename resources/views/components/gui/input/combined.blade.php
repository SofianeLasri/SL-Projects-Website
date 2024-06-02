<div {{ $attributes->merge(['class' => 'form-floating ' . $validationClass]) }} data-validation="{{ $validation }}">
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" class="form-control"
           data-form-type="{{ $dataFormType }}" value="{{ $value }}" {{ $required }}
           placeholder="{{ html_entity_decode($placeholder) }}">
    <label for="{{ $id }}">{{ html_entity_decode($label) }}</label>
</div>
