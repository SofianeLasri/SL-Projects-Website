<div class="d-flex flex-column {{ $class }}">
    <label for="{{ $id }}" class="form-label">{{ html_entity_decode($label) }}</label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
           placeholder="{{ $placeholder }}"
           data-form-type="{{ $dataFormType }}" value="{{ $value }}"
           class="form-control" {{ $required }}>
</div>
