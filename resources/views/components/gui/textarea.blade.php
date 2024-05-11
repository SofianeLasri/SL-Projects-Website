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

<div class="form-floating {{ $class }}">
    <textarea class="form-control" placeholder="{{ html_entity_decode($placeholder) }}"
              id="{{ $id }}" {{ $name }}>{{ $value }}</textarea>
    <label for="{{ $id }}">{{ html_entity_decode($label) }}</label>
</div>
