@extends('websites.showcase.layouts.public_app')

@section('head')
    <meta name="author" content="SofianeLasri">
    {{--<meta property="article:author" content="SofianeLasri">--}}
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ getWebsiteUrl("showcase") }}"/>
    <meta property="og:image" content="{{ Vite::asset("resources/images/logos/og-logo-orange.jpg") }}"/>
    <meta property="og:image:width" content="512"/>
    <meta property="og:image:height" content="512"/>
@endsection

@section('body')
    <x-showcase.navbar/>

    {{--Vitrine--}}
    <div class="home-showcase" id="homeShowcase">
        <div class="projects-presentations">
            <div class="desktop-controls">
                <div class="left">
                    <button onclick="previousPresentation()" class="control-button" type="button"
                            title="{{ __('general/noun.previous') }}"><i
                            class="fa-solid fa-chevron-left"></i></button>
                </div>
                <div class="right">
                    <button onclick="nextPresentation()" class="control-button" type="button"
                            title="{{ __('general/noun.next') }}"><i
                            class="fa-solid fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="presentation first active">
                <div class="content">
                    <div class="notice-text">
                        <span>Projet en vedette</span>
                    </div>
                    <h1>Starisland</h1>
                    <p>Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod empor incididunt.</p>
                </div>
            </div>
            <div class="presentation second">
                <div class="content">
                    <div class="notice-text">
                        <span>Projet en vedette</span>
                    </div>
                    <h1>Rosewood</h1>
                    <p>Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod empor incididunt.</p>
                </div>
            </div>
            <div class="presentation third">
                <div class="content">
                    <div class="notice-text">
                        <span>Projet en vedette</span>
                    </div>
                    <h1>Maisonette 9</h1>
                    <p>Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod empor incididunt.</p>
                </div>
            </div>
        </div>
        <div class="projects-cards">
            <div class="container d-flex flex-column align-items-center">
                <div class="responsive-title section-title text-white">
                    <span>Projets en vedette</span>
                </div>
                <div class="cards">
                    <div class="card active first">
                        <div class="title">Starisland</div>
                        <div class="description">Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            empor incididunt.
                        </div>
                    </div>
                    <div class="card second">
                        <div class="title">Rosewood</div>
                        <div class="description">Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            empor incididunt.
                        </div>
                    </div>
                    <div class="card third">
                        <div class="title">Maisonette 9</div>
                        <div class="description">Lorem ispum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                            empor incididunt.
                        </div>
                    </div>
                </div>
                <div class="dots-indicators">
                    <div class="dot active"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>
        </div>
    </div>
    {{--Fin vitrine--}}

    {{--Section 1--}}
    <section class="bg-primary">
        <div class="container">
            <h1 class="section-title">Projets récents</h1>
            <div class="recent-projects">
                <div>
                    <div class="news-card">
                        <div class="image"
                             style="background-image: url('{{ Vite::asset('resources/images/dev/placeholder.jpg') }}')">
                            <a href="#" class="linkOverlay"></a>
                        </div>
                        <div class="meta">
                            <span class="category"><a href="#">Catégorie</a></span>
                            <span>11 décembre 2022</span>
                        </div>
                        <a href="#" class="title">Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing elit, sed do
                            eiusmod tempor incidi</a>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="news-card horizontal-cards">
                        <div class="image"
                             style="background-image: url('{{ Vite::asset('resources/images/dev/placeholder.jpg') }}')">
                            <a href="#" class="linkOverlay"></a>
                        </div>
                        <div>
                            <div class="meta">
                                <span class="category"><a href="#">Catégorie</a></span>
                                <span>11 décembre 2022</span>
                            </div>
                            <a href="#" class="title">Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing elit, sed do
                                eiusmod tempor incidi</a>
                        </div>
                    </div>

                    <div class="news-card flex horizontal-cards">
                        <div class="image"
                             style="background-image: url('{{ Vite::asset('resources/images/dev/placeholder.jpg') }}')">
                            <a href="#" class="linkOverlay"></a>
                        </div>
                        <div>
                            <div class="meta">
                                <span class="category"><a href="#">Catégorie</a></span>
                                <span>11 décembre 2022</span>
                            </div>
                            <a href="#" class="title">Lorem Ipsum Dolor Sit Amet, Consectetur Adipiscing elit, sed do
                                eiusmod tempor incidi</a>
                        </div>
                    </div>

                    <a class="btn square btn-white" href="#">Voir tout <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
    {{--Fin section 1--}}

    {{--Section 2--}}
    <section>
        <div class="container">
            <h1 class="section-title">Création publiques</h1>
            <div id="publicProjects">
                @for($i = 0; $i <6; $i++)
                    <x-showcase.project-card projectSlug="placeholder"/>
                @endfor
            </div>
        </div>
    </section>
    {{--Fin section 2--}}

    <x-showcase.footer/>
@endsection

@push('scripts')
    <script type="text/javascript">
        const presentationTime = 10000;
        const presentationTransitionTime = 1000;
        const showCase = document.getElementById('homeShowcase');
        const presentations = showCase.getElementsByClassName('presentation');
        const presentationsCards = showCase.getElementsByClassName('card');
        let transitionInProgress = false;

        function initPresentationsCards() {
            for (let i = 0; i < presentationsCards.length; i++) {
                presentationsCards[i].addEventListener('click', function () {
                    showPresentation(i);
                });
            }
        }

        function getActivePresentationIndex() {
            for (let i = 0; i < presentations.length; i++) {
                if (presentations[i].classList.contains('active')) {
                    return i;
                }
            }
        }

        function showPresentation(index) {
            if (!transitionInProgress) {
                const activePresentationIndex = getActivePresentationIndex();
                if (activePresentationIndex !== index) {
                    presentations[activePresentationIndex].classList.remove('active');
                    presentations[index].classList.add('active');
                    presentationsCards[activePresentationIndex].classList.remove('active');
                    presentationsCards[index].classList.add('active');

                    updatePresentationCards(index);
                }
            }
        }

        function nextPresentation() {
            if (!transitionInProgress) {
                let activePresentationIndex = getActivePresentationIndex();
                let activePresentation = presentations[activePresentationIndex];
                let nextPresentation = presentations[activePresentationIndex + 1] || presentations[0];
                let nextPresentationIndex = activePresentationIndex + 1 < presentations.length ? activePresentationIndex + 1 : 0;

                transitionInProgress = true;
                nextPresentation.style.zIndex = 200;
                activePresentation.style.animation = 'hideRightToLeft ' + presentationTransitionTime + 'ms ease-in-out';
                nextPresentation.style.animation = 'showLeftToRight ' + presentationTransitionTime + 'ms ease-in-out';
                nextPresentation.classList.add('active');
                setTimeout(() => {
                    nextPresentation.style.removeProperty('z-index');
                    nextPresentation.style.removeProperty('animation');
                    activePresentation.style.removeProperty('animation');
                    activePresentation.classList.remove('active');
                    transitionInProgress = false;
                }, presentationTransitionTime);

                updatePresentationCards(nextPresentationIndex);
            }
        }

        function previousPresentation() {
            if (!transitionInProgress) {
                let activePresentationIndex = getActivePresentationIndex();
                let activePresentation = presentations[activePresentationIndex];
                let previousPresentation = presentations[activePresentationIndex - 1] || presentations[presentations.length - 1];
                let previousPresentationIndex = activePresentationIndex - 1 < 0 ? presentations.length - 1 : activePresentationIndex - 1;

                transitionInProgress = true;
                previousPresentation.style.zIndex = 200;
                activePresentation.style.animation = 'hideLeftToRight ' + presentationTransitionTime + 'ms ease-in-out';
                previousPresentation.style.animation = 'showRightToLeft ' + presentationTransitionTime + 'ms ease-in-out';
                previousPresentation.classList.add('active');
                setTimeout(() => {
                    previousPresentation.style.removeProperty('z-index');
                    previousPresentation.style.removeProperty('animation');
                    activePresentation.style.removeProperty('animation');
                    activePresentation.classList.remove('active');
                    transitionInProgress = false;
                }, presentationTransitionTime);

                updatePresentationCards(previousPresentationIndex);
            }
        }

        function updatePresentationCards(newPresentationIndex) {
            let activePresentationCard = presentationsCards[newPresentationIndex];
            let activePresentationCardDot = showCase.getElementsByClassName('dot')[newPresentationIndex];

            for (let i = 0; i < presentationsCards.length; i++) {
                presentationsCards[i].classList.remove('active');
            }
            for (let i = 0; i < showCase.getElementsByClassName('dot').length; i++) {
                showCase.getElementsByClassName('dot')[i].classList.remove('active');
            }

            activePresentationCard.classList.add('active');
            activePresentationCardDot.classList.add('active');
            autoMoveCardsContainerSlider();
        }

        function autoMoveCardsContainerSlider() {
            // Si le container cards a une barre de scroll, on va bouger le slider pour avoir la carte au centre
            if (showCase.getElementsByClassName('cards')[0].scrollWidth > showCase.getElementsByClassName('cards')[0].clientWidth) {
                let activePresentationCard = showCase.getElementsByClassName('card active')[0];
                let activePresentationCardIndex = Array.prototype.indexOf.call(presentationsCards, activePresentationCard);
                let activePresentationCardWidth = activePresentationCard.clientWidth;
                let activePresentationCardMargin = parseInt(window.getComputedStyle(activePresentationCard).getPropertyValue('margin-right'));
                let activePresentationCardOffset = activePresentationCardWidth + activePresentationCardMargin;
                let activePresentationCardPosition = activePresentationCardOffset * activePresentationCardIndex;
                let activePresentationCardCenterPosition = activePresentationCardPosition - (showCase.getElementsByClassName('cards')[0].clientWidth / 2) + (activePresentationCardWidth / 2);

                showCase.getElementsByClassName('cards')[0].scrollTo(activePresentationCardCenterPosition, 0);
            }

        }

        initPresentationsCards();
        setInterval(nextPresentation, presentationTime);

        // S'il y a trop de cartes dans publicProjects, on va masquer les autres
        const publicProjects = document.getElementById('publicProjects');
        const publicProjectsCards = publicProjects.getElementsByClassName('project-card');
        const projectCardWith = publicProjectsCards[0].clientWidth;
        const publicProjectsGap = parseInt(window.getComputedStyle(publicProjects).getPropertyValue('gap'));
        const projectCardOffset = projectCardWith + publicProjectsGap;

        function initPublicProjectsCards() {
            // Ne doit s'exécuter que sur les écrans de largeur supérieure à 768px
            if (window.innerWidth > 768) {
                let projectCardVisibleCount = Math.floor(publicProjects.clientWidth / projectCardOffset);
                let projectCardHiddenCount = publicProjectsCards.length - projectCardVisibleCount;

                // On masque les cartes qui ne sont pas visibles
                for (let i = 0; i < projectCardHiddenCount; i++) {
                    publicProjectsCards[publicProjectsCards.length - 1 - i].style.display = 'none';
                }

                // On affiche les cartes qui sont cachées
                for (let i = 0; i < projectCardVisibleCount; i++) {
                    publicProjectsCards[i].style.display = 'block';
                }
            }
        }

        // Losque la fenêtre est redimensionnée, on va vérifier si on doit afficher ou masquer des cartes
        window.addEventListener('resize', () => {
            initPublicProjectsCards();
        });

        initPublicProjectsCards();
    </script>
@endpush
