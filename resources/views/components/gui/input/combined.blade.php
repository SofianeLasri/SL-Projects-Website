<div {{ $attributes->merge(['class' => 'form-floating ' . $validationClass]) }} data-validation="{{ $validation }}">
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" class="form-control"
           placeholder="{{ html_entity_decode($placeholder) }}">
    <label for="{{ $id }}">{{ html_entity_decode($label) }}</label>
</div>
