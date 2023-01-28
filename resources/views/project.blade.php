@extends('layouts.public_app')

@section('pageName', 'Project')

@section('head')
    <meta name="author" content="SofianeLasri">
    <meta property="article:author" content="SofianeLasri">
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ config('app.url') }}"/>
    <meta property="og:image" content="{{ config('app.url').config('app.img.og.large') }}"/>
    <meta property="og:image:width" content="512"/>
    <meta property="og:image:height" content="512"/>
@endsection

@section('body')
    <x-navbar/>

    <div class="w-full bg-primary">
        <div class="custom-container flex flex-col pt-32 lg:pt-60 pb-10">
            <div class="flex lg:px-8">
                <div class="hidden lg:block w-80">
                    <!-- Supposée être vide -->
                </div>
                <div class="h-16 lg:pl-4">
                    <h1 class="font-black uppercase">StarIsland</h1>
                </div>
            </div>
            <div class="flex flex-col items-center lg:flex-row lg:items-start bg-white p-8 space-y-8 lg:space-y-0">
                <div class="lg:w-80 space-y-2 shrink-0 flex flex-col md:flex-row lg:flex-col md:space-x-2 lg:space-x-0">
                    <div class="shadows aspect-square lg:-mt-24 mb-2 max-lg:flex-1">
                        <img src="{{ mix('/images/dev/logo-starisland.jpg') }}" alt="Image du projet"
                             class="object-cover">
                    </div>

                    <div class="space-y-2 max-lg:flex-1">
                        <div class="notice-text">
                            <span>Informations du projet</span>
                        </div>
                        <div class="projectMeta">
                            <div class="flex justify-between">
                                <div><strong>Date de début</strong></div>
                                <div class="text-right">Janvier 2017</div>
                            </div>
                            <div class="flex justify-between">
                                <div><strong>Date de fin</strong></div>
                                <div class="text-right">Juin 2019</div>
                            </div>
                            <div class="flex justify-between">
                                <div><strong>Plateforme</strong></div>
                                <div class="text-right">Garry's Mod (Source Engine)</div>
                            </div>
                            <div class="flex justify-between">
                                <div><strong>Type de projet</strong></div>
                                <div class="text-right">Mapmaking</div>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <a href="#" class="btn square btn-primary" target="_blank">Voir le Workshop</a>
                            <a href="#" class="btn square btn-light" target="_blank"><i
                                    class="fa-sharp fa-solid fa-download"></i></a>
                        </div>
                    </div>
                </div>
                <div class="lg:pl-4">
                    <h3>Galerie</h3>
                    <div id="gallery" class="flex flex-wrap gap-2">
                        @for($i = 1; $i <= 7; $i++)
                            <div style="background-image: url('{{ mix('/images/dev/starisland-motel.jpg') }}');"
                                 class="bg-cover aspect-video h-32">
                                <div class="linkOverlay black"></div>
                            </div>
                        @endfor
                        <div class="bg-light aspect-video h-32 flex items-center justify-center">
                            <div class="h-6">
                                <x-logo-short color="#000"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="custom-container px-8 py-10 flex flex-col lg:flex-row gap-2">
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
        <div class="lg:w-80 shrink-0">
            <div class="flex flex-col">
                <h3><i class="fa-solid fa-clock-rotate-left"></i> Chronologie</h3>

                <div class="space-y-2">
                    <div>
                        <strong class="line-before">Janvier 2017</strong>
                        <ul class="list-disc ml-8">
                            <li>Création du projet</li>
                            <li>Recherche d'un partenaire</li>
                        </ul>
                    </div>
                    <div>
                        <strong class="line-before">Janvier 2017</strong>
                        <ul class="list-disc ml-8">
                            <li>Création du projet</li>
                            <li>Recherche d'un partenaire</li>
                        </ul>
                    </div>
                    <div>
                        <strong class="line-before">Janvier 2017</strong>
                        <ul class="list-disc ml-8">
                            <li>Création du projet</li>
                            <li>Recherche d'un partenaire</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-footer/>
@endsection

@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
