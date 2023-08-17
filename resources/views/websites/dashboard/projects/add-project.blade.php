@extends('websites.dashboard.layouts.app')

@section('pageName', 'Ajouter un projet')

@section('breadcrumbHeaderContent')
    <x-button type="button" class="btn-outline-dark">
        Prévisualiser
    </x-button>
    <x-button type="button" class="btn-dark">
        Enregistrer le brouillon
    </x-button>
    <x-button type="button" class="btn-primary">
        Publier
    </x-button>
@endsection

@section('pageContent')
    <div class="p-3">
        <div class="row">
            <div class="col-lg-6">
                <h5>Informations générales</h5>
                <x-input name="name" label="Nom du projet" placeholder="Entrez le nom du projet" class="mb-2"/>
                <x-input name="description" label="Description du projet" placeholder="Entrez la description du projets"
                         class="mb-2"/>
                <x-textarea name="description" label="Description du projet"
                            placeholder="Entrez la description du projets" rows="2"/>
            </div>
            <div class="col-lg-6">
                <h5>Illustrations du projet</h5>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
