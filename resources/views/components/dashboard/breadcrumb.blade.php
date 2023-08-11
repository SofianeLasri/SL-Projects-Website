<div class="breadcrumb">
    <x-button type="button" id="openSidebar" class="btn-dark btn-sm btn-square rounded {{ $sidebarOpened ? 'd-none' : '' }}"
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

@pushonce('scripts')
    <script type="text/javascript">
        const openSidebarButton = document.getElementById('openSidebar');

        openSidebarButton.addEventListener('click', () => {
            if (!sidebar.classList.contains('opened')) {
                sidebar.classList.add('opened');

                let xhr = new XMLHttpRequest();
                xhr.open('GET', '{{ route('ajax.set-sidebar-state', ['opened' => 'true']) }}');
                xhr.send();
            }
            openSidebarButton.classList.add('d-none');
        });
    </script>
@endpushonce
