@extends('websites.dashboard.layouts.app')

@section('pageName', 'Gestionnaire de fichiers')

@section('breadcrumbHeaderContent')
    <x-button id="uploadMedia" type="button" class="btn-primary" data-bs-toggle="modal"
              data-bs-target="#mediaUploadModal">
        Envoyer un média
    </x-button>
@endsection

@section('pageContent')
    <x-dashboard.media-library.embed class="px-3 pt-2 flex-grow-1" />

    <x-gui.modal id="mediaUploadModal" title="Envoyer un média" size="lg">
        <x-dashboard.media-library.media-upload-zone/>
    </x-gui.modal>
@endsection

@push('scripts')
    <script type="module">
        const mediaUploadZone = new MediaUploadZone();
        mediaUploadZone.setDebug({{ config('app.debug') ? 'true' : 'false' }});

        const mediaLibrary = new MediaLibrary();
        mediaLibrary.setTranslation('all-files', 'Tous les médias');
        mediaLibrary.setDebug({{ config('app.debug') ? 'true' : 'false' }});
        mediaLibrary.initialize();

        mediaUploadZone.on('onAllFileUploaded', (file) => {
            console.log('All files uploaded we can refresh the media library');
            mediaLibrary.refresh();
        });
    </script>
@endpush
