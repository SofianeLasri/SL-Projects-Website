<div id="sidebarLinks" class="d-flex flex-column gap-3">
    @foreach($categories as $category)
        <div class="d-flex flex-column gap-3">
            <div class="d-flex flex-column">
                <div class="fw-bold text-primary lh-1">{{ $category->title }}</div>
                <div class="small text-white-50">{{ $category->description }}</div>
            </div>

            <div class="d-flex flex-column gap-1">
                @foreach($category->children as $child)
                    @if($child->isGroup)
                        <x-button id="{{ $child->id }}" type="button"
                                  class="btn-dark rounded d-flex align-items-center gap-2" data-nav-link-type="group">
                            @if(!empty($child->icon))
                                <x-square-icon size="1.5rem">
                                    <i class="{{ $child->icon }}"></i>
                                </x-square-icon>
                            @endif
                            <div class="flex-grow-1 lh-1 text-start">{{ $child->title }}</div>
                            <x-square-icon size="1.5rem" data-nav-icon-type="group-dropdown">
                                <i class="fa-solid fa-angle-right"></i>
                            </x-square-icon>
                        </x-button>

                        <div class="d-none flex-column gap-1 ps-3" data-parent-nav-link="{{ $child->id }}"
                             data-status="closed">
                            @foreach($child->links as $link)
                                <x-button type="link"
                                          href="{{ Route::has($link->url) ? route($link->url) : $link->url }}"
                                          class="{{ request()->routeIs($link->url) ? 'btn-primary' : 'btn-dark' }} btn-sm rounded d-flex align-items-center gap-2">
                                    <x-square-icon size=".5rem" font-size=".25rem">
                                        <i class="fa-regular fa-circle"></i>
                                    </x-square-icon>
                                    <div class="flex-grow-1 lh-1">{{ $link->title }}</div>
                                </x-button>
                            @endforeach
                        </div>
                    @else
                        <x-button type="link" href="{{ Route::has($child->url) ? route($child->url) : $child->url }}"
                                  class="{{ request()->routeIs($child->url) ? 'btn-primary' : 'btn-dark' }} rounded d-flex align-items-center gap-2">
                            @if(!empty($child->icon))
                                <x-square-icon size="1.5rem">
                                    <i class="{{ $child->icon }}"></i>
                                </x-square-icon>
                            @endif
                            <div class="flex-grow-1 lh-1">{{ $child->title }}</div>
                        </x-button>
                    @endif
                @endforeach
            </div>
        </div>
    @endforeach
</div>

@pushonce('scripts')
    <script type="text/javascript">
        // Sélection de tous les éléments avec le dataset data-nav-link-type="group"
        const navLinksGroupElements = document.querySelectorAll('[data-nav-link-type="group"]');

        // Définition des icônes à utiliser
        const groupDropdownIconCloseHTML = '<i class="fa-solid fa-angle-down"></i>';
        const groupDropdownIconOpenHTML = '<i class="fa-solid fa-angle-right"></i>';

        navLinksGroupElements.forEach(groupElement => {
            // Ajout d'un événement au clic de la souris
            groupElement.addEventListener('click', () => {
                // Récupération de l'ID de l'élément cliqué
                const parentId = groupElement.id;

                // Sélection de tous les éléments dont le dataset data-parent-nav-link est égal à l'ID de l'élément cliqué
                const childElements = document.querySelectorAll(`[data-parent-nav-link="${parentId}"]`);

                childElements.forEach(childElement => {
                    // Vérification de l'état actuel de l'élément
                    const status = childElement.dataset.status;

                    // Trouver la div enfante avec le dataset "data-nav-icon-type"
                    const squareIconDiv = groupElement.querySelector('[data-nav-icon-type="group-dropdown"]');

                    if (status === 'closed') {
                        // Si l'état est "closed", afficher l'élément en remplaçant 'd-none' par 'd-flex'
                        childElement.classList.replace('d-none', 'd-flex');
                        childElement.dataset.status = 'opened';

                        // Mise à jour de la div avec le dataset "data-nav-icon-type"
                        if (squareIconDiv) {
                            squareIconDiv.innerHTML = groupDropdownIconCloseHTML;
                        }
                    } else {
                        // Si l'état est "opened", masquer l'élément en remplaçant 'd-flex' par 'd-none'
                        childElement.classList.replace('d-flex', 'd-none');
                        childElement.dataset.status = 'closed';

                        // Mise à jour de la div avec le dataset "data-nav-icon-type"
                        if (squareIconDiv) {
                            squareIconDiv.innerHTML = groupDropdownIconOpenHTML;
                        }
                    }
                });
            });
        });

    </script>
@endpushonce
