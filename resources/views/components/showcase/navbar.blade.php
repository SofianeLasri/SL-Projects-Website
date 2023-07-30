{{--Navbar--}}
<div class="navbar">
    <div class="desktop top-bar">
        <div class="left-part">
            <a href="{{ route('showcase.home') }}" class="logo">
                <x-logo-short/>
            </a>
            <x-showcase.nav-link href="{{ route('showcase.home') }}" :active="request()->routeIs('showcase.home')">
                {{ __('general/noun.home') }}
            </x-showcase.nav-link>
            <x-showcase.nav-link href="{{ route('showcase.projects') }}" :active="request()->routeIs('showcase.projects')">
                {{ __('general/noun.projects') }}
            </x-showcase.nav-link>
            <x-showcase.nav-link href="#">
                {{ __('general/noun.blog') }}
            </x-showcase.nav-link>
            <x-showcase.nav-link href="#">
                {{ __('general/noun.community') }}
            </x-showcase.nav-link>
            <x-showcase.nav-link href="https://sofianelasri.fr">
                {{ __('general/non-verbal.about-me') }}
            </x-showcase.nav-link>
        </div>
        <div class="right-part">
            <form class="search" type="get">
                <button class="text-btn" type="submit" title="{{ __('general/verb.to_search') }}"><i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" placeholder="{{ __('general/verb.to_search') }}" required>
            </form>
        </div>
    </div>

    {{--Navbar mobile--}}
    <div class="mobile">
        <div class="top-bar container">
            <button class="text-btn" id="openMobileMenu" type="button" title="{{ __('general/verbal.open-menu') }}"><i
                    class="fa-solid fa-bars"></i>
            </button>
            <a href="{{ route('showcase.home') }}">
                <img src="{{ Vite::asset('resources/images/logos/white-short.svg') }}" alt="Logo">
            </a>
            <button class="text-btn" id="focusMobileSearchBar" type="button" title="{{ __('general/verb.to_search') }}"><i
                    class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        {{--Masqué par défaut--}}
        <div id="mobileMenu" class="nav-links">
            <div class="container">
                <x-showcase.nav-link href="{{ route('showcase.home') }}" :active="request()->routeIs('home')">
                    {{ __('general/noun.home') }}
                </x-showcase.nav-link>
                <x-showcase.nav-link href="{{ route('showcase.projects') }}" :active="request()->routeIs('projects')">
                    {{ __('general/noun.projects') }}
                </x-showcase.nav-link>
                <x-showcase.nav-link href="#">
                    {{ __('general/noun.blog') }}
                </x-showcase.nav-link>
                <x-showcase.nav-link href="#">
                    {{ __('general/noun.community') }}
                </x-showcase.nav-link>
                <x-showcase.nav-link href="https://sofianelasri.fr">
                    {{ __('general/non-verbal.about-me') }}
                </x-showcase.nav-link>
                <form class="search" type="get">
                    <input id="mobileSearchBar" type="text" name="search" placeholder="{{ __('general/verb.to_search') }}"
                           required>
                    <button class="text-btn" type="submit" title="{{ __('general/verb.to_search') }}"><i
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
