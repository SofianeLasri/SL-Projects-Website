@extends('websites.showcase.layouts.public_app')

@section('pageName', 'Project')

@section('head')
    <meta name="author" content="SofianeLasri">
    <meta property="article:author" content="SofianeLasri">
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ getWebsiteUrl("showcase") }}"/>
    <meta property="og:image" content="{{ getWebsiteUrl("showcase").config('app.img.og.large') }}"/>
    <meta property="og:image:width" content="512"/>
    <meta property="og:image:height" content="512"/>
@endsection

@section('body')
    <x-showcase.navbar/>

    <div id="projectHeader" class="container-fluid">
        <div class="container">
            <div class="title-container flex lg:px-8">
                <div class="hidden-part">
                    <!-- Supposée être vide -->
                </div>
                <div class="title">
                    <h1 class="font-black text-uppercase m-0">StarIsland</h1>
                </div>
            </div>
            <div class="project-details-container">
                <div class="logo-and-details">
                    <div class="logo square-primary-shadows">
                        <img src="{{ Vite::asset('resources/images/dev/logo-starisland.jpg') }}" alt="Image du projet">
                    </div>

                    <div class="details">
                        <div class="notice-text mb-2">
                            <span>Informations du projet</span>
                        </div>
                        <div class="projectMeta mb-3">
                            <div class="d-flex justify-content-between">
                                <div><strong>Date de début</strong></div>
                                <div class="text-end">Janvier 2017</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div><strong>Date de fin</strong></div>
                                <div class="text-end">Juin 2019</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div><strong>Plateforme</strong></div>
                                <div class="text-end">Garry's Mod (Source Engine)</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div><strong>Type de projet</strong></div>
                                <div class="text-end">Mapmaking</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-primary" target="_blank">Voir le Workshop</a>
                            <a href="#" class="btn btn-light" target="_blank"><i
                                    class="fa-sharp fa-solid fa-download"></i></a>
                        </div>
                    </div>
                </div>
                <div class="gallery-container">
                    <h3>Galerie</h3>
                    <div id="gallery">
                        @for($i = 1; $i <= 7; $i++)
                            <div
                                style="background-image: url('{{ Vite::asset('resources/images/dev/starisland-motel.jpg') }}');"
                                class="media is-real-media"
                                data-src="{{ Vite::asset('resources/images/dev/starisland-motel.jpg') }}">
                                <div class="linkOverlay black"></div>
                            </div>
                        @endfor
                        {{--<div class="placeholder">
                            <div class="logo">
                                <x-logo-short color="#000"/>
                            </div>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="project-description-container">
        <div>
            <h1>Présentation</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore
                magna aliqua. Ut faucibus pulvinar elementum integer enim neque. Adipiscing elit ut aliquam purus sit
                amet.
                Potenti nullam ac tortor vitae. Amet consectetur adipiscing elit ut aliquam purus sit. Scelerisque
                viverra
                mauris in aliquam sem fringilla ut morbi tincidunt. Ipsum dolor sit amet consectetur adipiscing elit
                duis
                tristique sollicitudin. Diam quis enim lobortis scelerisque. Mattis rhoncus urna neque viverra justo
                nec.
                Odio morbi quis commodo odio aenean sed adipiscing diam. Tortor at risus viverra adipiscing.</p>

            <h2>Lorem ipsum</h2>
            <p>Varius morbi enim nunc faucibus a pellentesque sit amet porttitor. Augue neque gravida in fermentum et
                sollicitudin ac orci. Facilisis magna etiam tempor orci. Eget dolor morbi non arcu risus quis varius
                quam.
                Aliquam vestibulum morbi blandit cursus risus. Magna sit amet purus gravida. Convallis a cras semper
                auctor.
                Diam maecenas ultricies mi eget. Maecenas sed enim ut sem viverra aliquet. Tellus mauris a diam maecenas
                sed
                enim ut sem viverra. Diam quis enim lobortis scelerisque fermentum dui. Mi eget mauris pharetra et
                ultrices.
                Donec ac odio tempor orci dapibus ultrices in iaculis.</p>

            <p>Non quam lacus suspendisse faucibus interdum posuere lorem ipsum dolor. Hendrerit dolor magna eget est.
                In
                egestas erat imperdiet sed euismod nisi porta lorem mollis. Fusce ut placerat orci nulla. Ultrices
                tincidunt
                arcu non sodales neque sodales ut. Posuere ac ut consequat semper viverra. Egestas dui id ornare arcu
                odio
                ut sem nulla pharetra. Fringilla urna porttitor rhoncus dolor. Rhoncus mattis rhoncus urna neque
                viverra.
                Adipiscing bibendum est ultricies integer quis auctor. Metus vulputate eu scelerisque felis imperdiet
                proin
                fermentum. Aliquam malesuada bibendum arcu vitae. Suspendisse faucibus interdum posuere lorem ipsum
                dolor.
                Amet justo donec enim diam vulputate ut pharetra sit. Massa sed elementum tempus egestas sed.
                Pellentesque
                elit ullamcorper dignissim cras tincidunt lobortis feugiat vivamus at. Vulputate ut pharetra sit amet.
                Semper viverra nam libero justo laoreet sit amet.</p>
        </div>
        <div class="right-part">
            <div class="d-flex flex-column">
                <h3><i class="fa-solid fa-clock-rotate-left"></i> Chronologie</h3>

                <div class="my-3">
                    <div>
                        <strong class="line-before">Janvier 2017</strong>
                        <ul>
                            <li>Création du projet</li>
                            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut faucibus pulvinar elementum integer enim
                                neque.
                            </li>
                        </ul>
                    </div>
                    <div>
                        <strong class="line-before">Janvier 2017</strong>
                        <ul>
                            <li>Création du projet</li>
                            <li>Recherche d'un partenaire</li>
                        </ul>
                    </div>
                    <div>
                        <strong class="line-before">Janvier 2017</strong>
                        <ul>
                            <li>Création du projet</li>
                            <li>Recherche d'un partenaire</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-showcase.footer/>

    <x-showcase.photo-viewer/>
@endsection

@push('scripts')
    <script type="text/javascript">
        const projectHeader = document.getElementById('projectHeader');
        const gallery = document.getElementById('gallery');
        const galleryItems = gallery.querySelectorAll('.is-real-media');
        const galleryItemsCount = galleryItems.length;
        const placeholderHtml = `<div class="media placeholder"><div class="logo"><x-logo-short color="#000"/></div></div>`;

        galleryItems.forEach((item) => {
            item.addEventListener('click', () => {
                projectHeader.style.backgroundImage = `linear-gradient(to bottom,
                rgba(0, 0, 0, 0.2),
                rgba(0, 0, 0, 0.2)),
            url('${item.dataset.src}')`;
            });
        });

        function setPlaceholderImages() {
            let columns;
            let placeholders = document.querySelectorAll('.placeholder');

            placeholders.forEach((placeholder) => {
                placeholder.remove();
            });

            if (window.innerWidth >= 768 && window.innerWidth < 1440) {
                columns = 3;
            } else if (window.innerWidth >= 1440) {
                columns = 4;
            }

            let maxGalleryItems = (Math.ceil(galleryItemsCount / columns) * columns);
            if (placeholders.length < maxGalleryItems) {
                let placeholderCount = maxGalleryItems - galleryItemsCount;
                for (let i = 0; i < placeholderCount; i++) {
                    gallery.insertAdjacentHTML('beforeend', placeholderHtml);
                }
            }
        }

        setPlaceholderImages();

        window.addEventListener('resize', () => {
            setPlaceholderImages();
        });

        /*projectHeader.addEventListener('mouseleave', () => {
            projectHeader.style.backgroundImage = '';
        });*/
    </script>
@endpush
