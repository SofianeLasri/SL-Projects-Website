@props([
    'size' => "1rem",
])

<div class="square-icon" style="width: {{ $size }}; height: {{ $size }};">
    {{ $slot }}
</div>
