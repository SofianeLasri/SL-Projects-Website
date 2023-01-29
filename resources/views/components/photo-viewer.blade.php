<div id="photoViewer">
    <div class="top-bar">
        <div class="left-part">
            <a href="{{ route('home') }}" class="logo">
                <x-logo-short/>
            </a>
            <div class="title">
                <span>{{ $title }}</span>
            </div>
        </div>
    </div>
    <div class="photos-list">
        <button id="goFirst" class="preview-container" title="Aller à la première photo" disabled><i
                class="fa-solid fa-backward-step"></i>
        </button>
        <div id="photoPreviewList" class="photos">
            @for($i = 0; $i < 24; $i++)
                <div class="preview-container">
                    <img src="{{ mix('/images/dev/starisland-motel.jpg') }}" alt="Photo super passionnante">
                </div>
            @endfor
        </div>
        <button id="goLast" class="preview-container" title="Aller à la dernière photo"><i
                class="fa-solid fa-forward-step"></i>
    </div>
    <div class="main-frame">
        <div class="photos-carousel">
            <div class="carousel-items">
                @for($i = 0; $i < 24; $i++)
                    <div class="photo-container">
                        <img src="{{ mix('/images/dev/starisland-motel.jpg') }}" alt="Photo super passionnante">
                    </div>
                @endfor
            </div>
        </div>
        <div class="controls">
            <button class="fullscreen" title="{{ __('verb.fullscreen') }}"><i class="fa-solid fa-expand"></i></button>
            <button class="previous" title="{{ __('verb.previous') }}"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="next" title="{{ __('verb.next') }}"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
    </div>

</div>

@push('scripts')
    <script type="text/javascript">
        // On va bloquer le scroll de la page
        document.body.style.overflow = 'hidden';
    </script>
@endpush
