@extends('layouts.public_app')

@section('body')
    <x-navbar></x-navbar>

    <div class="vitrine">
        <div id="backgroundVideo">
            <noscript>
                <video autoplay loop muted>
                    <source src="{{ asset('videos/vitrine/starisland-1080p-2000kbps.webm') }}" type="video/webm">
                </video>
            </noscript>
            <div id="videoOverlay"></div>
        </div>

        <div class="content">
            <div class="text-content">
                <div class="title">
                    <span class="first">Sofiane Lasri's</span>
                    <span class="second">Projects</span>
                </div>
                <div class="description">
                    <p>Développeur web Full-Stack,
                    <br>UX & Game Designer.</p>
                </div>
            </div>

            <div class="projectsForms">
                <div class="first"></div>
                <div class="second"></div>
                <div class="third"></div>
                <div class="fourth"></div>
                <div class="fifth"></div>
                <div class="sixth"></div>
            </div>
        </div>
    </div>

    <div class="transitionVitrine"></div>
    <div class="transitionDetails">
        <div class="first"></div>
        <div class="second"></div>
        <div class="third"></div>
        <div class="fourth"></div>
    </div>

    <div id="indexPageContent">
        <div id="desktopStarislandStatue">
            <div class="statue"></div>
        </div>

        <div class="container vitrineFirstContainer">
            <div>
                <section>
                    <h2>Derniers projets</h2>
                    <div class="lastProjects">
                        <div class="cardContainer">
                            <div class="projectCard typeA">
                                <div>
                                    <span class="category">Développement Unity</span>
                                </div>
                                <div>
                                    <h1 class="title">Interface avec UI Toolkit</h1>
                                    <p class="date">Réalisé le 12/08/2022</p>
                                </div>
                            </div>

                            <div class="projectCard typeB red">
                                <div class="overlay">
                                    <h1 class="title">Site internet serveur MC SL-Craft</h1>
                                    <span class="category">Développement web</span>
                                    <div class="date">
                                        <span>Réalisé le 16/07/2022</span>
                                    </div>
                                </div>
                            </div>

                            <div class="vertical cardContainer">
                                <div class="projectCard typeB mid green">
                                    <div class="overlay">
                                        <h1 class="title">Plugin Minecraft Spigot mc</h1>
                                        <span class="category">Développement web</span>
                                        <div class="date">
                                            <span>Réalisé le 16/07/2022</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="projectCard typeB mid blue">
                                    <div class="overlay">
                                        <h1 class="title">Rosewood RP Serveur darkrp</h1>
                                        <span class="category">Développement web</span>
                                        <div class="date">
                                            <span>Réalisé le 16/07/2022</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <a class="pentaButton light" href="#">
                                <i class="fa-solid fa-right"></i>
                            </a>
                        </div>
                    </div>
                </section>
                <section>
                    <h2>Activité récente</h2>
                    <div class="recentActivity">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="blogPostCard">
                                <div class="header">
                                    <div class="bg">
                                        <a class="linkOverlay" href="#"></a>
                                    </div>
                                    <div class="tip">
                                        <span>Blog</span>
                                    </div>
                                </div>
                                <div class="postCategory">
                                    <a href="#">Source Engine</a>
                                </div>
                                <h4 class="postTitle">
                                    <a href="#">
                                        <span>S&Box, mon avis sur le successeur de Garry's Mod</span>
                                    </a>
                                </h4>
                                <div class="postMeta">
                                    <span>6 août 2021</span>
                                    <span><i class="fa-solid fa-eye"></i> 856 vues</span>
                                    <a href="#"><i class="fa-solid fa-share-nodes"></i> Partager</a>
                                </div>
                            </div>
                        @endfor
                    </div>
                </section>
            </div>
            <div>
                <!-- Cette div représente l'espace à la droite du conteneur -->
            </div>
        </div>
    </div>
@endsection
