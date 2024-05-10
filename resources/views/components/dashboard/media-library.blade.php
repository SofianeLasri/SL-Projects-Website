@props([
    'id' => 'mediaLibrary',
])

<div id="{{ $id }}" {{ $attributes->merge(['class' => 'media-library']) }}>
    <div class="filters">
        <div class="mobile-wrapper">
            <h4>Filtres</h4>
            <div class="content">
                <div class="d-flex flex-column flex-shrink-0 gap-2">
                    <h6>Types</h6>
                    <x-button type="button"
                              class="text-start d-flex align-items-center gap-2"
                              role="filter-by-type"
                              data-filter-by-type="all"
                    ><x-square-icon><i class="fa-solid fa-photo-film"></i></x-square-icon><div class="label">Tous les médias</div>
                    </x-button>
                    <x-button type="button"
                              class="text-start d-flex align-items-center gap-2"
                              role="filter-by-type"
                              data-filter-by-type="image"
                    ><x-square-icon><i class="fa-solid fa-image"></i></x-square-icon><div class="label">Images</div>
                    </x-button>
                    <x-button type="button"
                              class="text-start d-flex align-items-center gap-2"
                              role="filter-by-type"
                              data-filter-by-type="video"
                    ><x-square-icon><i class="fa-solid fa-film"></i></x-square-icon><div class="label">Vidéos</div>
                    </x-button>
                    <x-button type="button"
                              class="text-start d-flex align-items-center gap-2"
                              role="filter-by-type"
                              data-filter-by-type="other"
                    ><x-square-icon><i class="fa-solid fa-file"></i></x-square-icon><div class="label">Autres</div>
                    </x-button>
                </div>
                <div class="d-flex flex-column flex-shrink-0 gap-2">
                    <h6>Affichage</h6>
                    <x-button type="button"
                              class="text-start d-flex align-items-center gap-2"
                              role="view"
                              data-view="list"
                    ><x-square-icon><i class="fa-solid fa-list"></i></x-square-icon><div class="label">Liste</div>
                    </x-button>
                    <x-button type="button"
                              class="text-start btn-primary d-flex align-items-center gap-2"
                              role="view"
                              data-view="grid"
                              aria-selected="true"
                    ><x-square-icon><i class="fa-solid fa-table-cells-large"></i></x-square-icon><div class="label">Grille</div>
                    </x-button>
                </div>
                <div class="d-flex flex-column flex-shrink-0 gap-2">
                    <h6>Regrouper</h6>
                    <x-button type="button"
                              class="text-start d-flex align-items-center gap-2"
                              role="group"
                              data-group="none"
                    ><x-square-icon><i class="fa-solid fa-layer-group"></i></x-square-icon><div class="label">Ne pas regrouper</div>
                    </x-button>
                    <x-button type="button"
                              class="text-start btn-primary d-flex align-items-center gap-2"
                              role="group"
                              data-group="date"
                              aria-selected="true"
                    ><x-square-icon><i class="fa-solid fa-calendar"></i></x-square-icon><div class="label">Par date</div>
                    </x-button>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="medias">
            {{--@for($i = 0; $i < rand(1, 4); $i++)
                <div class="parent-section">
                    <h4>Septembre</h4>
                    <div class="parent-section-container">
                        @for($j = 0; $j < rand(1, 5); $j++)
                            <div class="section">
                                <h6>mardi 19 septembre</h6>
                                <div class="section-container">
                                    @for($j = 0; $j < rand(1, 24); $j++)
                                        <div class="media-element">
                                            <div class="meta">
                                                <div class="icon"><i class="fa-solid fa-file-pdf"></i></div>
                                                <div class="name">RandomFile.pdf</div>
                                            </div>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            @endfor--}}
        </div>
        <div class="actions">
            <div class="selected-files-label">5 médias sélectionnés</div>
            <div class="d-flex gap-2">
                <x-button type="button" class="btn-danger">Supprimer</x-button>
            </div>
        </div>
    </div>
</div>


<div class="modal modal-lg fade" id="mediaUploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Envoyer un média</h1>
                <x-button type="button" class="btn-link text-dark btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <x-square-icon size="1rem">
                        <i class="fa-solid fa-xmark"></i>
                    </x-square-icon>
                </x-button>
            </div>
            <div class="modal-body">
                <x-dashboard.media-upload-zone/>
            </div>
        </div>
    </div>
</div>

@pushonce('scripts')
    @vite(['resources/js/pages/dashboard/MediaLibrary.ts'])
@endpushonce
