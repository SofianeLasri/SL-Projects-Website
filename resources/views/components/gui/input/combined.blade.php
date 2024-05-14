<div class="form-floating {{ $class }}" data-validation="{{ $validation }}">
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" class="form-control"
           placeholder="{{ html_entity_decode($placeholder) }}">
    <label for="{{ $id }}">{{ html_entity_decode($label) }}</label>
</div>
