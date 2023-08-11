@props([
    'size' => "1.5rem",
    'fontSize' => null,
])

<div class="square-icon"
     style="width: {{ $size }}; height: {{ $size }}; {{ !empty($fontSize) ? "font-size: $fontSize;" : "" }}"
    {{ $attributes }}>
    {{ $slot }}
</div>
