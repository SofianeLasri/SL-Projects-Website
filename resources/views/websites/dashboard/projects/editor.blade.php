@extends('websites.dashboard.layouts.app')

@section('pageName', 'Ajouter un projet')

@section('breadcrumbHeaderContent')
    <x-button id="previewProjectBtn" type="button" class="btn-outline-dark">
        Prévisualiser
    </x-button>
    <x-button id="saveDraftBtn" type="button" class="btn-dark">
        Enregistrer le brouillon
    </x-button>
    <x-button id="publishProjectBtn" type="button" class="btn-primary">
        Publier
    </x-button>
@endsection

@section('pageContent')
    <x-dashboard.steps-group-list
            title="Étapes"
            :steps="[
                [
                    'id' => 'generalInformations',
                    'title' => 'Informations générales',
                    'active' => true
                ],
                [
                    'id' => 'content',
                    'title' => 'Contenu'
                ],
                [
                    'id' => 'medias',
                    'title' => 'Médias'
                ]
            ]"
            :use-check-icon="true">
        <form method="post" id="addProjectForm">
            @csrf
            <input type="hidden" name="project_id" value="{{ $fields['project-id'] }}">
            @if(!empty($fields['draft-id']))
                <input type="hidden" name="draft_id" value="{{ $fields['draft-id'] }}"/>
            @endif

            <div id="generalInformations">
                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <h5>Identité</h5>
                        <p class="d-none" id="projectSlugShowUp">Permalien : {{ getWebsiteUrl('showcase') }}</p>
                        <x-input id="projectNameInput" name="name" label="Nom du projet"
                                 placeholder="Entrez le nom du projet" value="{{ $fields['name'] }}"
                                 class="mb-2" required/>
                        <x-input id="projectSlugInput" name="slug" value="{{ $fields['slug'] }}" class="mb-2" hidden/>
                        <x-textarea name="description" label="Description du projet"
                                    value="{{ $fields['description'] }}"
                                    placeholder="Entrez la description du projets" rows="2" validation="valid" required
                                    feedback="Ceci est un feedback de test afin de vérifier que l'affichage est correct."/>
                    </div>

                    <div class="col-xl-6 mb-3">
                        <h5>Illustrations du projet</h5>
                        <x-input id="squareCoverInput" type="number" name="square-cover"
                                 label="ID Fileupload cover carrée" class="mb-2" value="{{ $fields['square-cover'] }}"/>
                        <x-input type="number" name="poster-cover" label="ID Fileupload poster" class="mb-2"
                                 value="{{ $fields['poster-cover'] }}"/>
                        <x-input type="number" name="fullwide-cover" label="ID Fileupload full wide" class="mb-2"
                                 value="{{ $fields['fullwide-cover'] }}"/>
                    </div>
                </div>

                <h5>Dates clés</h5>
                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <x-input type="date" name="start_date" label="Date de début" class="mb-2"
                                 value="{{ $fields['start-date'] }}" required/>
                        <label for="release_status" class="form-label>">Statut du projet</label>
                        <select class="form-select" aria-label="Default select example" name="release_status">
                            @foreach(\App\Models\Showcase\Project::RELEASE_STATUS_ENUMS as $status)
                                <option value="{{ $status }}"
                                        @if($fields['release-status'] === $status) selected @endif
                                >{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-6 mb-3">
                        <x-input type="date" name="end_date" label="Date de fin" class="mb-2"
                                 value="{{ $fields['end-date'] }}"/>
                    </div>
                </div>
            </div>

            <div id="content" class="d-none">
                <h5>Éditeur</h5>
                <div id="editor"></div>
            </div>

            <div id="medias" class="d-none">
                <x-input type="text" name="medias" label="Médias" class="mb-2"/>
            </div>
        </form>
        <textarea id="projectContent" class="d-none" hidden>{{ $fields['content'] }}</textarea>
    </x-dashboard.steps-group-list>

    <div class="modal modal-lg fade" id="chooseMediaModal" tabindex="-1" aria-labelledby="chooseMediaModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="chooseMediaModalLabel">Choisir un média</h1>
                    <x-button type="button" class="btn-link text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <x-square-icon size="1rem">
                            <i class="fa-solid fa-xmark"></i>
                        </x-square-icon>
                    </x-button>
                </div>
                <div class="modal-body">
                    <x-dashboard.media-library id="mediasMountPoint"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite(['resources/js/pages/dashboard/AddProject.ts'])
@endpush
