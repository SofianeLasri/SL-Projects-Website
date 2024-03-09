@extends('websites.dashboard.layouts.app')

@section('pageName', 'Gestionnaire de fichiers')

@section('breadcrumbHeaderContent')
    <x-button id="uploadMedia" type="button" class="btn-primary" data-bs-toggle="modal"
              data-bs-target="#mediaUploadModal">
        Envoyer un média
    </x-button>
@endsection

@section('pageContent')
    <x-dashboard.media-library class="px-3 pt-2 flex-grow-1" />
@endsection

@push('scripts')
    @vite(['resources/js/components/dashboard/MediaUploadZone.ts', 'resources/js/pages/dashboard/MediaLibrary.ts'])
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
