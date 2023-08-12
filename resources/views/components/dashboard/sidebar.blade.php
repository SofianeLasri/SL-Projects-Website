<div id="sidebar" class="bg-dark {{ $sidebarOpened ? 'opened' : '' }}">
    <div class="d-flex align-items-center gap-2">
        <div class="flex-grow-1">
            <x-logo-short height="1.5rem"/>
        </div>

        <x-button type="button" id="searchButton" class="btn-dark btn-sm btn-square rounded"
                  title="Faire une recherche">
            <x-square-icon>
                <i class="fa-solid fa-magnifying-glass"></i>
            </x-square-icon>
        </x-button>
        <x-button type="button" id="closeSidebar" class="btn-dark btn-sm btn-square rounded"
                  title="Fermer la barre de navigation">
            <x-square-icon>
                <i class="fa-solid fa-bars"></i>
            </x-square-icon>
        </x-button>
    </div>

    <div class="d-flex flex-column gap-2">
        <div class="d-flex gap-2 align-items-center">
            <x-dashboard.user-profile-picture/>
            <div class="d-flex flex-column">
                <div class="fw-bold text-white lh-1">{{ auth()->user()->username }}</div>
                <div class="small text-white-50">Creative Team</div>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <x-button type="button" id="openNotificationModal" class="btn-dark-alt btn-sm btn-square rounded"
                      title="Voir les notifications" badge-text="9">
                <x-square-icon>
                    <i class="fa-solid fa-bell"></i>
                </x-square-icon>
            </x-button>
            <x-button type="link" href="#" class="btn-dark-alt btn-sm btn-square rounded"
                      title="Rejoindre la page des paramètres">
                <x-square-icon>
                    <i class="fa-solid fa-cog"></i>
                </x-square-icon>
            </x-button>
            <x-button type="link" href="{{ route('logout') }}"
                      class="btn-danger btn-sm rounded d-flex align-items-center gap-1"
                      title="Rejoindre la page des paramètres">
                <x-square-icon>
                    <i class="fa-solid fa-right-from-bracket"></i>
                </x-square-icon>
                <span class="fw-bold lh-1">Se déconnecter</span>
            </x-button>
        </div>
    </div>

    <x-dashboard.navigation/>
</div>

@pushonce('scripts')
    <script type="text/javascript">
        const closeSidebarButton = document.getElementById('closeSidebar');

        document.addEventListener('DOMContentLoaded', () => {
            let sidebar = document.getElementById('sidebar');
            let hasVerticalScrollbar = sidebar.scrollHeight > sidebar.clientHeight;


            if (hasVerticalScrollbar) {
                const scrollbarWidth = sidebar.offsetWidth - sidebar.clientWidth;
                sidebar.style.width = `${sidebar.offsetWidth + scrollbarWidth}px`;
            }

            closeSidebarButton.addEventListener('click', () => {
                if (sidebar.classList.contains('opened')) {
                    sidebar.classList.remove('opened');

                    let xhr = new XMLHttpRequest();
                    xhr.open('GET', '{{ route('ajax.set-sidebar-state', ['opened' => 'false']) }}');
                    xhr.send();
                }
                document.getElementById('openSidebar').classList.remove('d-none');
            });
        });
    </script>
@endpushonce
