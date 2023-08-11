@props([
    'id' => null,
    'class' => null,
    'badgeColor' => "primary",
    'badgeText' => null,
    'type' => "button",
    'title' => null,
    'href' => null,
    'target' => null
])

@php
    if(!in_array($type, ['link', 'submit', 'reset', 'button'])) {
        throw \Illuminate\Validation\ValidationException::withMessages(
            [
                'type' => "Button type '$type' is incorrect. Possible types are 'link', 'submit', 'reset' and 'button'."
            ]
        );
    }
    if($type !== 'link' && !empty($href)) {
        throw \Illuminate\Validation\ValidationException::withMessages(
            [
                'href' => "Buttons of type '$type' can't have 'href' attribute. Only 'link' ones."
            ]
        );
    }
    if(!empty($target)) {
        if($type !== 'link') {
            throw \Illuminate\Validation\ValidationException::withMessages(
                [
                    'target' => "Buttons of type '$type' can't have 'target' attribute. Only 'link' ones."
                ]
            );
        } else {
            if(!in_array($target, ['_blank', '_self', '_parent', '_top'])) {
                throw \Illuminate\Validation\ValidationException::withMessages(
                    [
                        'target' => "Target type '$target' is incorrect. Possible types are '_blank', '_self', '_parent' and '_top'."
                    ]
                );
            }
        }
    }

    $tagName = "a";
    if($type !== 'link') $tagName = "button";
@endphp

<{{ $tagName }}
    class="btn {{ $class }}"

@if(!empty($id))
    id="{{ $id }}"
@endif
@if(!empty($title))
    title="{{ $title }}"
@endif

@if($tagName === "a")
    @if(!empty($href))
        href="{{ $href }}"
    @endif
    @if(!empty($target))
        target="{{ $target }}"
    @endif
@else
    type="{{ $type }}"
@endif

@if(!empty($badgeText))
    data-has-badge="yes" style="overflow: visible;"
@endif
{{ $attributes }}
>
@if(!empty($badgeText))
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-{{ $badgeColor }} z-1">
        {{ $badgeText }}
    </span>
@endif
{{ $slot }}
</{{ $tagName }}>

@pushonce('scripts')
    <script type="text/javascript">
        function createButtonRipple(event) {
            const button = event.currentTarget;

            const circle = document.createElement("span");
            const diameter = Math.max(button.clientWidth, button.clientHeight);
            const radius = diameter / 2;

            circle.style.width = circle.style.height = `${diameter}px`;
            circle.style.left = `${event.clientX - (button.offsetLeft + radius)}px`;
            circle.style.top = `${event.clientY - (button.offsetTop + radius)}px`;
            circle.classList.add("ripple");

            const ripple = button.getElementsByClassName("ripple")[0];

            if (ripple) {
                ripple.remove();
            }

            button.appendChild(circle);

            setTimeout(() => {
                circle.remove();
            }, 600);
        }

        const buttons = document.querySelectorAll('.btn:not([data-has-badge="yes"])');
        for (const button of buttons) {
            button.addEventListener("click", createButtonRipple);
        }
    </script>
@endpushonce
