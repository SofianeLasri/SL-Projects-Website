@if($apparence === "input")
    <x-gui.input apparence="combined" :name="$name" :id="$id" :label="$label" type="number"/>
@else

@endif

<div class="modal modal-lg fade" id="modalId" tabindex="-1" aria-labelledby="modalIdLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalIdLabel">Modal Title</h1>
                <x-button type="button" class="btn-link text-dark" data-bs-dismiss="modal" aria-label="Close">
                    <x-square-icon size="1rem">
                        <i class="fa-solid fa-xmark"></i>
                    </x-square-icon>
                </x-button>
            </div>
            <div class="modal-body">
                <!-- Modal content -->
            </div>
            <div class="modal-footer">
                <!-- Modal footer -->
            </div>
        </div>
    </div>
</div>

@pushonce('scripts')
    @vite(['resources/js/components/dashboard/media-library/InputPicker.ts'])
@endpushonce
