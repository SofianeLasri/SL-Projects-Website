@extends('layouts.public_app')

@section('body')
    <x-navbar></x-navbar>

    <div class="vitrine">
        <div id="backgroundVideo">
            <noscript>
                <video autoplay loop muted>
                    <source src="{{ mix('/videos/vitrine/starisland-1080p-2000kbps.webm') }}" type="video/webm">
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
                    <p>{{ __("pages/vitrine.vitrine.description_first") }}
                    <br>{{ __("pages/vitrine.vitrine.description_second") }}</p>
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
                    <h2>{{ __("generic.last_projects") }}</h2>
                    <div class="lastProjects">
                        <div class="cardContainer">
                            <div class="projectCard typeA">
                                <div>
                                    <span class="category">{{ __("categories.development.Unity") }}</span>
                                </div>
                                <div>
                                    <h1 class="title">Interface avec UI Toolkit</h1>
                                    <p class="date">{{ __("generic.made.on.date") }} 12/08/2022</p>
                                </div>
                            </div>

                            <div class="projectCard typeB red">
                                <div class="overlay">
                                    <h1 class="title">Site internet serveur MC SL-Craft</h1>
                                    <span class="category">{{ __("categories.development.Web") }}</span>
                                    <div class="date">
                                        <span>{{ __("generic.made.on.date") }} 16/07/2022</span>
                                    </div>
                                </div>
                            </div>

                            <div class="vertical cardContainer">
                                <div class="projectCard typeB mid green">
                                    <div class="overlay">
                                        <h1 class="title">Plugin Minecraft Spigot mc</h1>
                                        <span class="category">{{ __("categories.development.Web") }}</span>
                                        <div class="date">
                                            <span>{{ __("generic.made.on.date") }} 16/07/2022</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="projectCard typeB mid blue">
                                    <div class="overlay">
                                        <h1 class="title">Rosewood RP Serveur darkrp</h1>
                                        <span class="category">{{ __("categories.development.Web") }}</span>
                                        <div class="date">
                                            <span>{{ __("generic.made.on.date") }} 16/07/2022</span>
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
                                        <span>{{ __("singleWords.blog") }}</span>
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
                                    <span><i class="fa-solid fa-eye"></i> 856 {{ strtolower(__("singleWords.views")) }}</span>
                                    <a href="#"><i class="fa-solid fa-share-nodes"></i> {{ __("singleWords.share") }}</a>
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

        <div class="container-fluid steamWorkshopProfile">
            <div class="container">
                <div class="profile">
                    <a class="profilePic"
                       title="{{ __("generic.link_to_my_steam_profile") }}"
                       href="https://steamcommunity.com/profiles/{{ $steamUserProfileInformations->get("steamid") }}"
                       style="background-image: url('{{ $steamUserProfileInformations->get("avatarfull") }}');"></a>
                    <div class="profileMeta">
                        <a href="https://steamcommunity.com/profiles/{{ $steamUserProfileInformations->get("steamid") }}" class="accountName">{{ $steamUserProfileInformations->get("personaname") }}</a>
                    </div>
                </div>

                <section class="creations">
                    <h2>Mon Workshop Steam</h2>
                    <div class="d-flex">
                        @foreach($workshopItems as $workshopItem)
                            <div class="creation">
                                <a class="cover"
                                   style="background-image: url('/images/steam/workshop/covers/{{ $workshopItem['id'] }}.jpg');"
                                   href="https://steamcommunity.com/sharedfiles/filedetails/?id={{ $workshopItem['id'] }}"
                                   title="{{ __("generic.link_to") }} {{ $workshopItem['name'] }}"></a>
                                <div class="meta">
                                    <div class="stars">
                                        <img src="/images/steam/workshop/stars/{{ $workshopItem['stars'] }}-star_large.png"
                                             alt="{{ $workshopItem['stars'] > 0 ? __("singleWords.stars") : __("singleWords.star") }}">
                                    </div>
                                    <span class="votes">{{ $workshopItem['votes'] }} {{ __("singleWords.ratings") }}</span>
                                </div>
                                <a class="title"
                                   href="https://steamcommunity.com/sharedfiles/filedetails/?id={{ $workshopItem['id'] }}"
                                   title="{{ __("generic.link_to") }} {{ $workshopItem['name'] }}">
                                    {{ $workshopItem['name'] }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
