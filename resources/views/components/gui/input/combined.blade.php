<div {{ $attributes->merge(['class' => 'form-floating']) }}>
    <input id="{{ $id }}" name="{{ $name }}" type="{{ $type }}" class="form-control {{ $validationClass }}"
           data-form-type="{{ $dataFormType }}" value="{{ $value }}" {{ $required }}
           placeholder="{{ html_entity_decode($placeholder) }}">
    <label for="{{ $id }}">{{ html_entity_decode($label) }}</label>
    @if($validFeedback)
        <div class="valid-feedback">{{ $validFeedback }}</div>
    @endif
    @if($invalidFeedback)
        <div class="invalid-feedback">{{ $invalidFeedback }}</div>
    @endif
</div>
