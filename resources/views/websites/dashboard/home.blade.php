@extends('websites.dashboard.layouts.app')

@section('pageName', 'Accueil')

@section('pageContent')
    <div class="px-3 py-2">
        <h3>Il n'y a rien à voir ici, pour l'instant...</h3>
        <p class="mb-5">Je pointe personne du doigt, mais je pense que la personne qui écrit ça devrait plutôt bosser
            sur d'autres pages plus utiles. 👀</p>

        <h5>Exemple de pages utiles à faire</h5>
        <p>Selon leur ordre de priorité...</p>
        <ul>
            <li>Page de création et d'édition de projets</li>
            <li>Page listant ces projets <img
                    src="https://cdn.discordapp.com/emojis/659821889186824192.webp?size=128&quality=lossless"
                    width="28px"></li>
        </ul>

        <p class="fw-bold">Optionnel si le blog n'est pas prévu pour tout de suite</p>
        <ul>
            <li>Page de création et d'édition de catégories</li>
            <li>Page listant ces catégories</li>
            <li>Page de création et d'édition d'articles de blog</li>
            <li>Page listant ces articles de blog... (on a compris je crois)</li>
        </ul>

        <p class="fw-bold">Optionnel si le blog n'est pas fait, ou si le système de commentaires n'est pas pressé.</p>
        <ul>
            <li>Page de création et d'édition d'utilisateur</li>
            <li>Page pour les lister</li>
            <li>Page permettant de gérer les permissions du site (et permissions à implémenter sur l'ensemble du projet)</li>
            <li>Page de conditions générales d'utilisations pour l'inscription</li>
            <li>Page de modération des commentaires</li>
            <li>Terminer la page d'inscription (peaufinage + fonctionnalités emails)</li>
        </ul>

        <p class="fw-bold">Osef, debug et stats</p>
        <ul>
            <li>Faire l'interface permettant d'afficher toutes les requêtes reçues</li>
        </ul>

        <p>Et puis en dehors des pages, il y a aussi ça à développer :</p>
        <h5>Exemple de fonctionnalités utiles à faire</h5>
        <p class="fw-bold">Pas urgent</p>
        <ul>
            <li>Système de notification sur le dashboard</li>
            <li>Réparer le système de logout ? <img
                    src="https://cdn.discordapp.com/emojis/932407281704910889.webp?size=128&quality=lossless"
                    width="28px"></li>
        </ul>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
