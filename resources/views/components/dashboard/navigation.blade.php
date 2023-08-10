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
                        <x-button type="button" class="btn-dark rounded d-flex align-items-center gap-2">
                            @if(!empty($child->icon))
                                <x-square-icon size="1.5rem">
                                    <i class="{{ $child->icon }}"></i>
                                </x-square-icon>
                            @endif
                            <div class="flex-grow-1 lh-1 text-start">{{ $child->title }}</div>
                            <x-square-icon size="1.5rem">
                                <i class="fa-solid fa-angle-right"></i>
                            </x-square-icon>
                        </x-button>

                        <div class="d-none">
                            @foreach($child->links as $link)
                                <a href="{{ Route::has($child->url) ? route($child->url) : $child->url }}">{{ $link->title }}</a>
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
