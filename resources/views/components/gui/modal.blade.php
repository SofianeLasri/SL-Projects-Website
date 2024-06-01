@props([
    'id',
    'title',
    'size' => 'md',
    'scrollable' => false,
    'staticBackdrop' => false,
    'centered' => false,
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true" @if($staticBackdrop) data-bs-backdrop="static" data-bs-keyboard="false" @endif>
    <div class="modal-dialog{{ $centered ? ' modal-dialog-centered' : '' }}{{ $scrollable ? ' modal-dialog-scrollable' : '' }} modal-{{ $size }}">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $id }}Label">{{ $title }}</h1>
                <x-button type="button" class="btn-link text-dark btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <x-square-icon size="1rem">
                        <i class="fa-solid fa-xmark"></i>
                    </x-square-icon>
                </x-button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            @isset($footer)
                <div class="modal-footer">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
