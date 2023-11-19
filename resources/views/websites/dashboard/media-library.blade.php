@extends('websites.dashboard.layouts.app')

@section('pageName', 'Gestionnaire de fichiers')

@section('breadcrumbHeaderContent')
    <x-button id="uploadMedia" type="button" class="btn-primary" data-bs-toggle="modal" data-bs-target="#mediaUploadModal">
        Envoyer un média
    </x-button>
@endsection

@section('pageContent')
    <div class="px-3 py-2 media-library" id="mediaLibrary">
        <div class="filters">
            <h4>Filtres</h4>
            <div class="content">
                <div class="d-flex flex-column flex-shrink-0 gap-2">
                    <h6>Types</h6>
                    <x-button type="button"
                              class="text-start"
                              role="filter-by-type"
                              data-filter-by-type="all"
                    >Tous les médias</x-button>
                    <x-button type="button"
                              class="text-start"
                              role="filter-by-type"
                              data-filter-by-type="images"
                    >Images</x-button>
                    <x-button type="button"
                              class="text-start"
                              role="filter-by-type"
                              data-filter-by-type="videos"
                    >Vidéos</x-button>
                    <x-button type="button"
                              class="text-start"
                              role="filter-by-type"
                              data-filter-by-type="files"
                    >Fichiers</x-button>
                </div>
                <div class="d-flex flex-column flex-shrink-0 gap-2">
                    <h6>Affichage</h6>
                    <x-button type="button"
                              class="text-start"
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
                    <h6>Regrouper</h6>
                    <x-button type="button"
                              class="text-start"
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
                              class="text-start"
                              role="group"
                              data-group="type"
                    >Par type</x-button>
                </div>
            </div>
        </div>
        <div class="medias" id="mediaLibraryMedias">
            {{--@for($i = 0; $i < rand(1, 4); $i++)
                <div class="parent-section">
                    <h4>Septembre</h4>
                    <div class="parent-section-container">
                        @for($j = 0; $j < rand(1, 5); $j++)
                            <div class="section">
                                <h6>mardi 19 septembre</h6>
                                <div class="section-container">
                                    @for($j = 0; $j < rand(1, 24); $j++)
                                        <div class="file">
                                            <div class="icon"><i class="fa-solid fa-file-pdf"></i></div>
                                            <div class="name">RandomFile.pdf</div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            @endfor--}}
        </div>
    </div>


    <div class="modal modal-lg fade" id="mediaUploadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Envoyer un média</h1>
                    <x-button type="button" class="btn-link text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <x-square-icon size="1rem">
                            <i class="fa-solid fa-xmark"></i>
                        </x-square-icon>
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
    <script type="module">
        const mediaUploadZone = new MediaUploadZone();
        const mediaLibrary = new MediaLibrary();
        mediaLibrary.setTranslation('all-files', 'Tous les médias');
        mediaLibrary.initialize();
    </script>
@endpush
