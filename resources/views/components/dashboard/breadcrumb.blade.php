<div class="breadcrumb">
    <x-button type="button" id="openSidebar"
              class="btn-dark btn-sm btn-square rounded {{ $sidebarOpened ? 'd-none' : '' }}"
              title="Ouvrir la barre de navigation">
        <x-square-icon>
            <i class="fa-solid fa-bars"></i>
        </x-square-icon>
    </x-button>
    <div class="links">
        @for($i = 0; $i < count($breadcrumbs); $i++)
            @if($i === count($breadcrumbs) - 1)
                <a href="{{ $breadcrumbs[$i]['url'] }}" class="text-white fw-bold">{{ $breadcrumbs[$i]['name'] }}</a>
            @else
                @if(!empty($breadcrumbs[$i]['url']) && $breadcrumbs[$i]['url'] !== '#')
                    <a href="{{ $breadcrumbs[$i]['url'] }}">{{ $breadcrumbs[$i]['name'] }}</a>
                @else
                    <div>{{ $breadcrumbs[$i]['name'] }}</div>
                @endif
            @endif
            @if($i < count($breadcrumbs) - 1)
                <i class="fa-solid fa-angle-right"></i>
            @endif
        @endfor
    </div>
</div>

@if(!$disableHeader)
    <div class="content-after-breadcrumb p-3 d-flex gap-3 flex-wrap">
        <div class="d-flex gap-3 flex-grow-1">
            @if(!empty($pageIcon))
                <x-square-icon size="4rem" font-size="2rem"
                               class="border border-primary rounded-3 bg-primary-subtle text-primary">
                    <i class="{{ $pageIcon }}"></i>
                </x-square-icon>
            @endif
            <div class="flex-grow-1">
                <h4 class="mt-2 mb-1">{{ $pageTitle }}</h4>
                @if(!empty($pageDescription))
                    <p class="text-muted m-0">{{ $pageDescription }}</p>
                @endif
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap align-items-center">
            {{ $slot }}
        </div>
    </div>
@endif

@pushonce('scripts')
    <script type="text/javascript">
        const openSidebarButton = document.getElementById('openSidebar');

        openSidebarButton.addEventListener('click', () => {
            let sidebar = document.getElementById('sidebar');
            if (!sidebar.classList.contains('opened')) {
                sidebar.classList.add('opened');

                let xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route('dashboard.ajax.set-sidebar-state', ['opened' => 'true']) }}');
                xhr.send();
            }
            openSidebarButton.classList.add('d-none');
        });
    </script>
@endpushonce
