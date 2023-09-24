@extends('websites.dashboard.layouts.app')

@section('pageName', 'Gestionnaire de fichiers')

@section('breadcrumbHeaderContent')
    <x-button id="uploadMedia" type="button" class="btn-primary" data-bs-toggle="modal" data-bs-target="#mediaUploadModal">
        Envoyer un média
    </x-button>
@endsection

@section('pageContent')
    <div class="px-3 py-2 media-library">
        <div class="filters d-flex flex-column gap-4">
            <h4>Filtres</h4>
            <div class="content">
                <div class="d-flex flex-column flex-shrink-0 gap-2">
                    <div class="fw-bold">Types</div>
                    <x-button type="button"
                              class="text-start btn-primary"
                              role="filter"
                              data-filter="all"
                              aria-selected="true"
                    >Tous les médias</x-button>
                    <x-button type="button"
                              class="text-start btn-white"
                              role="filter"
                              data-filter="images"
                    >Images</x-button>
                    <x-button type="button"
                              class="text-start btn-white"
                              role="filter"
                              data-filter="videos"
                    >Vidéos</x-button>
                    <x-button type="button"
                              class="text-start btn-white"
                              role="filter"
                              data-filter="files"
                    >Fichiers</x-button>
                </div>
                <div class="d-flex flex-column flex-shrink-0 gap-2">
                    <div class="fw-bold">Affichage</div>
                    <x-button type="button"
                              class="text-start btn-white"
                              role="view"
                              data-view="list"
                    >Liste</x-button>
                    <x-button type="button"
                              class="text-start btn-primary"
                              role="view"
                              data-view="grid"
                              aria-selected="true"
                    >Grille</x-button>
                </div>
                <div class="d-flex flex-column flex-shrink-0 gap-2">
                    <div class="fw-bold">Regrouper</div>
                    <x-button type="button"
                              class="text-start btn-white"
                              role="group"
                              data-group="none"
                    >Ne pas regrouper</x-button>
                    <x-button type="button"
                              class="text-start btn-primary"
                              role="group"
                              data-group="date"
                              aria-selected="true"
                    >Par date</x-button>
                    <x-button type="button"
                              class="text-start btn-white"
                              role="group"
                              data-group="type"
                    >Par type</x-button>
                </div>
            </div>
        </div>
        <div class="medias d-flex flex-column flex-grow-1">
            <div class="d-flex flex-column gap-4">
                <h4>Septembre</h4>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex flex-column gap-2">
                        <div class="fw-bold">mardi 19 septembre</div>
                        <div class="d-flex flex-wrap gap-3">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-lg fade" id="mediaUploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Envoyer un média</h1>
                    <x-button type="button" class="text-btn text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa fa-times"></i>
                    </x-button>
                </div>
                <div class="modal-body">
                    <x-dashboard.media-upload-zone />
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
