<div id="photoViewer">
    <div class="top-bar">
        <div class="left-part">
            <a href="{{ route('showcase.home') }}" class="logo">
                <x-logo-short/>
            </a>
            <div class="title">
                <span>{{ $title }}</span>
            </div>
        </div>
        <div class="right-part">
            <button id="closeButton"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>
    <div class="photos-list">
        <button id="goFirst" class="preview-container" title="Aller à la première photo" disabled><i
                class="fa-solid fa-backward-step"></i>
        </button>
        <div id="photoPreviewList" class="photos">
            @for($i = 0; $i < 24; $i++)
                <div class="preview-container">
                    <img src="{{ Vite::asset('resources/images/dev/starisland-motel.jpg') }}"
                         alt="Photo super passionnante">
                </div>
            @endfor
        </div>
        <button id="goLast" class="preview-container" title="Aller à la dernière photo"><i
                class="fa-solid fa-forward-step"></i></button>
    </div>
    <div class="main-frame">
        <div class="photos-carousel">
            <div id="caroussel" class="carousel-items">
                @for($i = 0; $i < 24; $i++)
                    <div class="photo-container">
                        <img src="{{ Vite::asset('resources/images/dev/starisland-motel.jpg') }}"
                             alt="Photo super passionnante">
                    </div>
                @endfor
            </div>
        </div>
        <div class="controls">
            <button class="fullscreen" title="{{ __('general/verb.fullscreen') }}"><i class="fa-solid fa-expand"></i>
            </button>
            <button class="previous" title="{{ __('general/verb.previous') }}"><i class="fa-solid fa-chevron-left"></i>
            </button>
            <button class="next" title="{{ __('general/verb.next') }}"><i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>

</div>

@push('scripts')
    <script type="text/javascript">
        function openPhotoViewer() {
            document.getElementById('photoViewer').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closePhotoViewer() {
            document.getElementById('photoViewer').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        document.getElementById('closeButton').addEventListener('click', closePhotoViewer);

        // Carousel
        const carousel = document.getElementById('caroussel');
        const carouselParent = carousel.parentElement;
        const carouselItems = carousel.querySelectorAll('.photo-container');
        const carouselItemsCount = carouselItems.length;
        const carouselItemWidth = carouselItems[0].offsetWidth;
        let mouseDown = false;
        let cursorX;
        let scrollLeft;

        carouselParent.addEventListener('mousedown', (e) => {
            mouseDown = true;
            cursorX = e.offsetX - carousel.offsetLeft;
            carousel.style.cursor = 'grabbing';
        });
        // Pour mobiles
        carouselParent.addEventListener('touchstart', (e) => {
            mouseDown = true;
            cursorX = e.touches[0].clientX - carousel.offsetLeft;
            carousel.style.cursor = 'grabbing';
        });

        carouselParent.addEventListener('mousemove', (e) => {
            if (!mouseDown) return;
            e.preventDefault();
            carousel.style.left = `${e.offsetX - cursorX}px`;
        });
        // Pour mobiles
        carouselParent.addEventListener('touchmove', (e) => {
            if (!mouseDown) return;
            e.preventDefault();
            carousel.style.left = `${e.touches[0].clientX - cursorX}px`;
        });

        window.addEventListener('mouseup', () => {
            mouseDown = false;
        });
    </script>
@endpush
