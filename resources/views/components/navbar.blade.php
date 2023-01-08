{{--Navbar--}}
<div class="navbar">
    <div class="desktop top-bar">
        <div class="left-part">
            <a href="{{ route('home') }}" class="logo">
                <img src="{{ mix('/images/logos/white-short.svg') }}" alt="Logo">
            </a>
            <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                {{ __('word.home') }}
            </x-nav-link>
            <x-nav-link href="{{ route('projects') }}" :active="request()->routeIs('projects')">
                {{ __('word.projects') }}
            </x-nav-link>
            <x-nav-link href="#">
                {{ __('word.blog') }}
            </x-nav-link>
            <x-nav-link href="#">
                {{ __('word.community') }}
            </x-nav-link>
            <x-nav-link href="https://sofianelasri.fr">
                {{ __('non-verbal.about-me') }}
            </x-nav-link>
        </div>
        <div class="right-part">
            <form class="search" type="get">
                <button type="submit" title="{{ __('verb.to_search') }}"><i class="fa-solid fa-magnifying-glass"></i>
                </button>
                <input type="text" name="search" placeholder="{{ __('verb.to_search') }}">
            </form>
        </div>
    </div>

    {{--Navbar mobile--}}
    <div class="mobile">
        <div class="top-bar">
            <button id="openMobileMenu" type="button" title="{{ __('verbal.open-menu') }}" class="burger"><i
                    class="fa-solid fa-bars"></i>
            </button>
            <a href="{{ route('home') }}">
                <img src="{{ mix('/images/logos/white-short.svg') }}" alt="Logo">
            </a>
            <button type="button" class="search" title="{{ __('verb.to_search') }}"><i
                    class="fa-solid fa-magnifying-glass"></i></button>
        </div>
        {{--Masqué par défaut--}}
        <div id="mobileMenu" class="nav-links">
            <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                {{ __('word.home') }}
            </x-nav-link>
            <x-nav-link href="{{ route('projects') }}" :active="request()->routeIs('projects')">
                {{ __('word.projects') }}
            </x-nav-link>
            <x-nav-link href="#">
                {{ __('word.blog') }}
            </x-nav-link>
            <x-nav-link href="#">
                {{ __('word.community') }}
            </x-nav-link>
            <x-nav-link href="https://sofianelasri.fr">
                {{ __('non-verbal.about-me') }}
            </x-nav-link>
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
    </script>
@endpush
