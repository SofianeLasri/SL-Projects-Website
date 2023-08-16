@props([
    'name' => '',
    'id' => '',
    'label' => "",
    'checked' => false
])

@php
    $id = !empty($id) ? $id : 'checkbox_' . $name;
    $label = !empty($label) ? $label : $name;
@endphp

<div class="form-check">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" {{ $checked ? 'checked' : '' }} class="form-check-input">
    <label for="{{ $id }}" class="form-check-label">{{ html_entity_decode($label) }}</label>
</div>
