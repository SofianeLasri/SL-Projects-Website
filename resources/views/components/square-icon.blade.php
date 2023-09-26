@props([
    'size' => "1.5rem",
    'fontSize' => null,
    'class' => null,
])

<div class="square-icon {{ $class }}"
     style="width: {{ $size }}; {{ !empty($fontSize) ? "font-size: $fontSize;" : "" }}{{ !empty($fontSize) ? "line-height: $fontSize;" : "" }}"
    {{ $attributes }}>
    {{ $slot }}
</div>
