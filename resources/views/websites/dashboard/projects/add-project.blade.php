@extends('websites.dashboard.layouts.app')

@section('pageName', 'Ajouter un projet')

@section('breadcrumbHeaderContent')
    <x-button type="button" class="btn-outline-dark">
        Prévisualiser
    </x-button>
    <x-button type="button" class="btn-dark">
        Enregistrer le brouillon
    </x-button>
    <x-button id="publishBtn" type="button" class="btn-primary" disabled>
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
                    'id' => 'chronology',
                    'title' => 'Chronologie'
                ]
            ]"
        :use-check-icon="true" >
        <form method="post" id="addProjectForm">
            @csrf
            <div id="generalInformations">
                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <h5>Identité</h5>
                        <p class="d-none" id="projectSlugShowUp">Permalien : {{ getWebsiteUrl('showcase') }}</p>
                        <x-input id="projectNameInput" name="name" label="Nom du projet" placeholder="Entrez le nom du projet"
                                 class="mb-2" required/>
                        <x-textarea name="description" label="Description du projet"
                                    placeholder="Entrez la description du projets" rows="2" validation="valid" required
                                    feedback="Ceci est un feedback de test afin de vérifier que l'affichage est correct."/>
                    </div>
                    <div class="col-xl-6 mb-3">
                        <h5>Illustrations du projet</h5>
                        <x-input type="number" name="square-cover" label="ID Fileupload cover carrée" class="mb-2"/>
                        <x-input type="number" name="dvd-cover" label="ID Fileupload cover dvd" class="mb-2"/>
                    </div>
                </div>

                <h5>Dates clés</h5>
                <div class="row">
                    <div class="col-xl-6 mb-3">
                        <x-input type="date" name="startDate" label="Date de début" class="mb-2" required/>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>Status du projet</option>
                            @foreach(\App\Models\Showcase\Project::STATUS_ENUMS as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-6 mb-3">
                        <x-input type="date" name="endDate" label="Date de fin" class="mb-2"/>
                    </div>
                </div>

                <h5></h5>
            </div>
            <div id="content" class="d-none">
                <h5>Éditeur</h5>
                <div id="editor"></div>
            </div>
            <div id="chronology" class="d-none">

            </div>
        </form>
    </x-dashboard.steps-group-list>
@endsection

@push('scripts')
    <script type="module">
        const websiteUrl = '{{ getWebsiteUrl('showcase') }}';

        const projectCreationFieldsName = ['name', 'description'];
        const formValidator = new FormValidator(projectCreationFieldsName);

        const projectNameInput = document.getElementById('projectNameInput');
        const projectNameInputInstance = new Input(projectNameInput);
        const projectSlugShowUp = document.getElementById('projectSlugShowUp');

        projectNameInput.addEventListener('change', event => {
            generateSlugAndVerifySlugAndProjectName();
        });

        function generateSlugAndVerifySlugAndProjectName() {
            if (projectNameInput.value !== '') {
                // Affichage du permalien
                if (projectSlugShowUp.classList.contains('d-none')) {
                    projectSlugShowUp.classList.remove('d-none');
                }

                // Génération du slug
                let slug = slugify(projectNameInput.value, {
                    lower: true, // Convertir en minuscules
                    strict: true // Remplacer les caractères spéciaux par des tirets
                });
                let url = websiteUrl + '/project/' + slug;

                projectSlugShowUp.innerHTML = 'Permalien : <a href="' + url + '">' + url + '</a>';

                // Vérification de l'existence du slug dans la base de données
                let checkUrl = '{{ route('dashboard.ajax.projects.check-slug') }}';
                let data = new FormData();
                data.append('slug', slug);

                let xhr = new XMLHttpRequest();
                xhr.open('POST', checkUrl, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        let response = JSON.parse(xhr.responseText);
                        if (response.slugAlreadyUsed) {
                            projectNameInputInstance.invalidate('Ce permalien est déjà utilisé.');
                            formValidator.changeField('name', false);
                        } else {
                            projectNameInputInstance.removeValidation();
                            formValidator.changeField('name', true);
                        }
                    }
                }

                xhr.send(data);
            } else {
                if (!projectSlugShowUp.classList.contains('d-none')) {
                    projectSlugShowUp.classList.add('d-none');
                }
                formValidator.changeField('name', false);
            }
        }

        formValidator.onValidated(() => {
            document.getElementById('publishBtn').disabled = false;
        });

        formValidator.onInvalidated(() => {
            document.getElementById('publishBtn').disabled = true;
        });

        document.addEventListener("DOMContentLoaded", (event) => {
            generateSlugAndVerifySlugAndProjectName();
        });

        const editor = new TuiEditor({
            el: document.querySelector('#editor'),
            height: '500px',
            initialEditType: 'markdown',
            previewStyle: 'vertical'
        });

        editor.getMarkdown();
    </script>
@endpush
