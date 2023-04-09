{{--Navbar--}}
<div class="navbar">
    <div class="desktop top-bar">
        <div class="left-part">
            <a href="{{ route('home') }}" class="logo">
                <x-logo-short/>
            </a>
            <x-showcase.nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                {{ __('word.home') }}
            </x-showcase.nav-link>
            <x-showcase.nav-link href="{{ route('projects') }}" :active="request()->routeIs('projects')">
                {{ __('word.projects') }}
            </x-showcase.nav-link>
            <x-showcase.nav-link href="#">
                {{ __('word.blog') }}
            </x-showcase.nav-link>
            <x-showcase.nav-link href="#">
                {{ __('word.community') }}
            </x-showcase.nav-link>
            <x-showcase.nav-link href="https://sofianelasri.fr">
                {{ __('non-verbal.about-me') }}
            </x-showcase.nav-link>
        </div>
        <div class="right-part">
            <form class="search" type="get">
                <button type="submit" title="{{ __('verb.to_search') }}"><i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" placeholder="{{ __('verb.to_search') }}" required>
            </form>
        </div>
    </div>

    {{--Navbar mobile--}}
    <div class="mobile">
        <div class="top-bar custom-container">
            <button id="openMobileMenu" type="button" title="{{ __('verbal.open-menu') }}"><i
                    class="fa-solid fa-bars"></i>
            </button>
            <a href="{{ route('home') }}">
                <img src="{{ Vite::asset('resources/images/logos/white-short.svg') }}" alt="Logo">
            </a>
            <button id="focusMobileSearchBar" type="button" title="{{ __('verb.to_search') }}"><i
                    class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        {{--Masqué par défaut--}}
        <div id="mobileMenu" class="nav-links">
            <div class="custom-container">
                <x-showcase.nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                    {{ __('word.home') }}
                </x-showcase.nav-link>
                <x-showcase.nav-link href="{{ route('projects') }}" :active="request()->routeIs('projects')">
                    {{ __('word.projects') }}
                </x-showcase.nav-link>
                <x-showcase.nav-link href="#">
                    {{ __('word.blog') }}
                </x-showcase.nav-link>
                <x-showcase.nav-link href="#">
                    {{ __('word.community') }}
                </x-showcase.nav-link>
                <x-showcase.nav-link href="https://sofianelasri.fr">
                    {{ __('non-verbal.about-me') }}
                </x-showcase.nav-link>
                <form class="search" type="get">
                    <input id="mobileSearchBar" type="text" name="search" placeholder="{{ __('verb.to_search') }}"
                           required>
                    <button type="submit" title="{{ __('verb.to_search') }}"><i
                            class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
{{--Fin Navbar--}}

@push('scripts')
    <script type="text/javascript">
        // Ouverture du menu mobile
        document.getElementById('openMobileMenu').addEventListener('click', function () {
            document.getElementById('mobileMenu').classList.toggle('open');
        });

        // Focus sur la barre de recherche mobile
        document.getElementById('focusMobileSearchBar').addEventListener('click', function () {
            // On check si le menu n'est pas déjà ouvert
            if (!document.getElementById('mobileMenu').classList.contains('open')) {
                document.getElementById('mobileMenu').classList.toggle('open');
            }
            document.getElementById('mobileSearchBar').focus();
        });

        // Fermeture du menu mobile lorsqu'on clique en dehors
        document.addEventListener('click', function (event) {
            if (!event.target.closest('#mobileMenu') && !event.target.closest('#openMobileMenu') && !event.target.closest('#focusMobileSearchBar')) {
                document.getElementById('mobileMenu').classList.remove('open');
            }
        });
    </script>
@endpush
