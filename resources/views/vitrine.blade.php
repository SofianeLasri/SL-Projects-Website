@extends('layouts.public_app')

@section('head')
    <meta name="description" content="Site internet personnel de SofianeLasri">
    <meta name="author" content="SofianeLasri">
    <meta property="og:title" content="SL-Projects" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ config('app.url') }}" />
    <meta property="og:image" content="{{ config('app.url').config('app.img.og.large') }}" />
    <meta property="og:image:width" content="512" />
    <meta property="og:image:height" content="512" />
    <meta property="og:locale" content="fr_FR" />
    <meta property="og:locale:alternate" content="en_US" />
@endsection

@section('body')
    <x-navbar></x-navbar>

    <div class="vitrine">
        <div id="backgroundVideo">
            <noscript>
                <video autoplay loop muted>
                    <source src="{{ mix('/videos/vitrine/starisland-1080p-2000kbps.webm') }}" type="video/webm">
                </video>
            </noscript>
            <div id="videoOverlay">
            </div>
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
            <div class="comment">
                <div class="title">The world is yours... Almost.</div>
                <p>Cette satue issue du film Scarface avait été commandée par un ancien riche gouverneur de l'île
                    Starisland... <i class="fa-solid fa-right"></i></p>
            </div>
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
                       style="background-image: url('{{ $steamUserProfileInformations->get("avatarfull") }}');"
                       target="_blank"></a>
                    <div class="profileMeta">
                        <a href="https://steamcommunity.com/profiles/{{ $steamUserProfileInformations->get("steamid") }}"
                           class="accountName"
                           target="_blank">{{ $steamUserProfileInformations->get("personaname") }}</a>
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
                                   title="{{ __("generic.link_to") }} {{ $workshopItem['name'] }}"
                                   target="_blank"></a>
                                <div class="meta">
                                    <div class="stars">
                                        <img src="/images/steam/workshop/stars/{{ $workshopItem['stars'] }}-star_large.png"
                                             alt="{{ $workshopItem['stars'] > 0 ? __("singleWords.stars") : __("singleWords.star") }}">
                                    </div>
                                    <span class="votes">{{ $workshopItem['votes'] }} {{ __("singleWords.ratings") }}</span>
                                </div>
                                <a class="title"
                                   href="https://steamcommunity.com/sharedfiles/filedetails/?id={{ $workshopItem['id'] }}"
                                   title="{{ __("generic.link_to") }} {{ $workshopItem['name'] }}"
                                   target="_blank">
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

@push("scripts")
    <script type="text/javascript">
        // Constantes
        const websiteUrl = "{{ config('app.url') }}";
        const introContainer = document.getElementById("backgroundVideo");
        const vitrineIntroVideo = document.createElement("video");
        const currentProjectName = "starisland";

        vitrineIntroVideo.muted = true;
        vitrineIntroVideo.loop = true;
        introContainer.appendChild(vitrineIntroVideo);

        // On va regarder la correspondance en Média Query de l'écran pour afficher la vidéo appropriée
        window.mobileAndTabletCheck = function () {
            let check = false;
            (function (a) {
                if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
            })(navigator.userAgent || navigator.vendor || window.opera);
            return check;
        };

        const isMobileOrTablet = window.mobileAndTabletCheck();
        const screenWithouDPI = window.screen.width * window.devicePixelRatio;

        if((isMobileOrTablet && window.matchMedia("(min-width: 2500px)").matches) || (!isMobileOrTablet && screenWithouDPI > 2500)){
            vitrineIntroVideo.src = websiteUrl + "/videos/vitrine/" + currentProjectName + "-1440p-2666kbps.webm";
        }else if((isMobileOrTablet && window.matchMedia("(min-width: 1900px)").matches) || (!isMobileOrTablet && screenWithouDPI > 1900)){
            vitrineIntroVideo.src = websiteUrl + "/videos/vitrine/" + currentProjectName + "-1080p-2000kbps.webm";
        }else{
            vitrineIntroVideo.src = websiteUrl + "/videos/vitrine/" + currentProjectName + "-720p-1333kbps.webm";
        }
        vitrineIntroVideo.play();

    </script>
@endpush
