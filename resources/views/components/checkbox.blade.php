@props([
    'name' => '',
    'id' => '',
    'label' => "",
    'checked' => false,
])

@php
    $id = !empty($id) ? $id : 'checkbox_' . uniqid();
@endphp

<div class="form-check">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" {{ $checked ? 'checked' : '' }} class="form-check-input">
    @if(!empty($label))
        <label for="{{ $id }}" class="form-check-label">{{ html_entity_decode($label) }}</label>
    @endif
</div>
