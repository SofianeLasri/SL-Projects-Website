<div {{ $attributes->merge(['class' => 'd-flex flex-column']) }} >
    <label for="{{ $id }}" class="form-label">{{ html_entity_decode($label) }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
           placeholder="{{ $placeholder }}"
           data-form-type="{{ $dataFormType }}" value="{{ $value }}"
           class="form-control {{  $validationClass }}" {{ $required }}>
</div>
