<div id="{{ $id }}" class="file">
    <x-square-icon size="3.15rem" font-size="1.25rem" class="icon">
        <i class="{{ $icon }}"></i>
    </x-square-icon>
    <div class="infos">
        <div class="meta">
            <div class="name">{{ $name }}</div>
            <div class="size">{{ $formattedSize }}</div>
        </div>
        <div class="progress-bar">
            <div class="progress" style="width: 0"></div>
        </div>
    </div>
    <div class="actions">
        <x-button type="button" class="btn-link text-dark file-close-btn">
            <x-square-icon size="1rem">
                <i class="fa-solid fa-xmark"></i>
            </x-square-icon>
        </x-button>
    </div>
</div>
