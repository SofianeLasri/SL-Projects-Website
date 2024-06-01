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
            <input type="hidden" name="project-id" value="{{ $fields['project-id'] }}">
            @if(!empty($fields['draft-id']))
                <input type="hidden" name="draft-id" value="{{ $fields['draft-id'] }}"/>
            @endif

            <div id="generalInformations">
                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <h5>Identité</h5>
                        <p class="d-none" id="projectSlugShowUp">Permalien : {{ getWebsiteUrl('showcase') }}</p>
                        <x-gui.input id="projectNameInput" name="name" label="Nom du projet"
                                     placeholder="Entrez le nom du projet" value="{{ $fields['name'] }}"
                                     class="mb-2" required/>
                        <x-gui.input id="projectSlugInput" name="slug" value="{{ $fields['slug'] }}" class="mb-2"
                                     hidden/>
                        <x-gui.textarea name="description" label="Description du projet"
                                        value="{{ $fields['description'] }}" rows="2"
                                        placeholder="Entrez la description du projets" rows="2" validation="valid"
                                        required
                                        feedback="Ceci est un feedback de test afin de vérifier que l'affichage est correct."/>
                    </div>

                    <div class="col-xl-6 mb-3">
                        <h5>Illustrations du projet</h5>
                        <x-dashboard.media-library.input-picker id="squareCoverInput" name="square-cover" type="image"
                                                                apparence="input" label="Illustration carrée" file-count="2"
                                                                class="mb-2" :value="$fields['square-cover']"/>
                        {{--<x-gui.input id="squareCoverInput" type="number" name="square-cover"
                                     label="ID Fileupload cover carrée" class="mb-2"
                                     value="{{ $fields['square-cover'] }}"/>--}}
                        <x-gui.input type="number" name="poster-cover" label="ID Fileupload poster" class="mb-2"
                                     value="{{ $fields['poster-cover'] }}"/>
                        <x-gui.input type="number" name="fullwide-cover" label="ID Fileupload full wide" class="mb-2"
                                     value="{{ $fields['fullwide-cover'] }}"/>
                    </div>
                </div>

                <h5>Dates clés</h5>
                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <x-gui.input type="date" name="start-date" label="Date de début" class="mb-2"
                                     value="{{ $fields['start-date'] }}" required/>
                        <label for="release-status" class="form-label>">Statut du projet</label>
                        <select class="form-select" aria-label="Default select example" name="release-status">
                            @foreach(\App\Models\Showcase\Project::RELEASE_STATUS_ENUMS as $status)
                                <option value="{{ $status }}"
                                        @if($fields['release-status'] === $status) selected @endif
                                >{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-6 mb-3">
                        <x-gui.input type="date" name="end-date" label="Date de fin" class="mb-2"
                                     value="{{ $fields['end-date'] }}"/>
                    </div>
                </div>
            </div>

            <div id="content" class="d-none">
                <h5>Éditeur</h5>
                <div id="editor"></div>
            </div>

            <div id="medias" class="d-none">
                <x-gui.input type="text" name="medias" label="Médias" class="mb-2"/>
            </div>
        </form>
        <textarea id="projectContent" class="d-none" hidden>{{ $fields['content'] }}</textarea>
    </x-dashboard.steps-group-list>
@endsection

@push('scripts')
    @vite(['resources/js/pages/dashboard/AddProject.ts'])
@endpush
