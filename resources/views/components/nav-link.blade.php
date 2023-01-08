@props(['active'])

@php
    $classes = ($active ?? false)
        ? 'nav-link active'
        : 'nav-link ';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <div class="link-container">
        {{ $slot }}
    </div>
</a>
