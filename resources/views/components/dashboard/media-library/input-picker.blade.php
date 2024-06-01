@if($apparence === "input")
    <div {{ $attributes->merge(['class' => 'media-picker input-group']) }}
         data-target-id="{{$id}}"
         data-target-name="{{$name}}"
         data-file-count="{{$fileCount}}">
        <span class="input-group-text">
            <i class="{{ config('global-ui.fa-file-types-icons.' . $type) }}"></i>
        </span>
        <x-gui.input apparence="combined" :name="$fakeInputName" :id="$fakeInputId" :label="$label" type="text"/>
    </div>
@else

@endif
<input type="hidden" name="{{ $name }}" id="{{ $id }}"/>

@pushonce('afterPageContent')
    <x-gui.modal id="mediaPickerModal" title="Choisir un média" size="xl" scrollable>
        <x-dashboard.media-library.embed id="embededMediaLibrary"/>
        <x-slot:footer>
            <x-button type="button" class="btn-light" data-bs-dismiss="modal">
                Annuler
            </x-button>
            <x-button type="button" class="btn-primary">
                Choisir
            </x-button>
        </x-slot:footer>
    </x-gui.modal>
@endpushonce

@pushonce('scripts')
    @vite(['resources/js/components/dashboard/media-library/InputPicker.ts'])
@endpushonce
