<div class="modal modal-lg fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
