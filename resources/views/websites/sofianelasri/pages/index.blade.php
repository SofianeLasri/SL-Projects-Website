@extends('websites.sofianelasri.layouts.public_app')

@section('head')
    <meta name="author" content="SofianeLasri">
    {{--<meta property="article:author" content="SofianeLasri">--}}
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ getWebsiteUrl("showcase") }}"/>
    <meta property="og:image" content="{{ getWebsiteUrl("showcase").config('app.img.og.large') }}"/>
    <meta property="og:image:width" content="512"/>
    <meta property="og:image:height" content="512"/>
@endsection

@section('body')
    <nav class="mt-4">
        <div class="container d-flex">
            <div class="flex-grow-1">
                <x-logo-short height="2.625rem"/>
                <span class="ms-3 title">Sofiane Lasri</span>
            </div>
            <div>
                <ul>
                    <li class="active">
                        <a href="#">CV</a>
                    </li>
                    <li>
                        <a href="{{ route('showcase.home') }}">Aller sur SL-Projects.com</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container intro">
        <div class="meta">
            <h1>Sofiane Lasri</h1>
            <div class="sub-title">Développeur web Full-Stack</div>
            <p class="desc">Salut, moi c’est Sofiane !
                <br>Je suis développeur web Full-Stack chez
                <a href="https://www.kang.fr" target="_blank" title="Visiter le site de mon employeur">Kang.fr</a> la
                semaine, et programmeur tous langages le
                week-end. :D</p>
            <p>Je m'intéresse beaucoup à la création de jeux vidéos.</p>

            <div class="links mt-3 d-flex gap-2 flex-wrap">
                <a href="https://1drv.ms/b/s!Atk178NpnuLmg8UgVBq-olbfisT0KQ?e=wiqcM0"
                   class="btn btn-primary rounded-pill"
                   target="_blank"
                   title="Télécharger mon CV"><i class="fa-solid fa-file-pdf"></i> Télécharger mon CV</a>
                <a href="https://github.com/SofianeLasri/"
                   class="btn btn-outline-primary rounded-pill"
                   target="_blank" title="Visiter mon profil GitHub">
                    <i class="fa-brands fa-github"></i>
                </a>
                <a href="https://gitlab.sl-projects.com/SofianeLasri/"
                   class="btn btn-outline-primary rounded-pill"
                   target="_blank" title="Visiter mon GitLab personnel">
                    <i class="fa-brands fa-gitlab"></i>
                </a>
                <a href="https://www.linkedin.com/in/sofiane-lasri-trienpont/"
                   class="btn btn-outline-primary rounded-pill"
                   target="_blank" title="Visiter mon profil LinkedIn">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
            </div>
        </div>
        <div class="bigHead"
             style="background-image: url('{{ Vite::asset('resources/images/sofianelasri/Studio Couleur 1000px.jpg') }}');">
        </div>
    </div>

    <section class="container mb-4">
        <h2>Mes compétences</h2>
        <h4 class="sub-title mb-4">En programmation</h4>

        <div class="skills">
            <div class="skill">
                <div class="icon">
                    <i class="fa-brands fa-laravel"></i>
                </div>
                <div class="desc">
                    <h3>Laravel</h3>
                    <p>Laravel est mon framework de prédilection.
                        <br>Travaillant quotidiennement dessus aussi bien dans le cadre professionnel que personnel,
                        j’ai pu acquérir une certaine expérience qui me permet aujourd’hui de l’utiliser dans tous mes
                        projets web.</p>
                </div>
            </div>

            <div class="skill">
                <div class="icon">
                    <i class="fa-brands fa-php"></i>
                </div>
                <div class="desc">
                    <h3>PHP</h3>
                    <p>Programmant en PHP depuis de nombreuses années (2019), j’ai créé de nombreux projets avec ce
                        langage. Allant du simple site internet au framework maison, je me suis forgé au fil des
                        années une véritable base de connaissances.</p>
                </div>
            </div>

            <div class="skill">
                <div class="icon">
                    <i class="fa-brands fa-html5"></i>
                    <i class="fa-brands fa-css3"></i>
                </div>
                <div class="desc">
                    <h3>HTML & CSS</h3>
                    <p>J’ai une bonne expérience en ce qui concerne la réalisation d’interface. En effet, adorant
                        imaginer et créer des maquettes sur Figma, la maîtrise de CSS devient indispensable au moment de
                        la réalisation.</p>
                </div>
            </div>

            <div class="skill">
                <div class="icon">
                    <i class="fa-brands fa-js"></i>
                </div>
                <div class="desc">
                    <h3>Javascript</h3>
                    <p>Qui dit HTML & CSS, dit JS ! Rendre un site dynamique est toujours une tâche fastidieuse, mais
                        très satisfaisante une fois terminée. Ainsi, j’ai pu me former en ECMA Script durant mes
                        projets, mais également à l’université, où j’ai pu apprendre la version 5 (quelle galère !).</p>
                </div>
            </div>

            <div class="skill">
                <div class="icon">
                    <i class="fa-brands fa-java"></i>
                </div>
                <div class="desc">
                    <h3>Java</h3>
                    <p>Au début un peu réticent, j’ai pu acquérir un bon niveau en Java grâce à mon serveur Minecraft
                        (qui l’eu cru :D). Jeu développé en Java oblige, il a fallu que je m’y mette pour développer
                        mon serveur.
                        <br>Par la suite, j’ai pu en apprendre davantage à l’université au travers des projets Android
                        Studio.</p>
                    <p class="fw-normal">Je sais même créer des applis pour Nokia 6230 avec J2ME ! :D</p>
                </div>
            </div>

            <div class="skill">
                <div class="icon">
                    <i class="fa-brands fa-unity"></i>
                </div>
                <div class="desc">
                    <h3>Unity & C#</h3>
                    <p>Étant un grand fan de jeux vidéo, j’ai toujours rêvé de réaliser le mien. Ainsi, c’est au
                        travers de mes très nombreuses tentatives et prototypes que j’ai pu gagner en expérience en C#,
                        mais aussi dans la création de jeux vidéo.
                        <br>Il peut aussi m’arriver de développer des petites applications en C# sur mon temps libre.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5">
        <h4 class="sub-title">Annexes</h4>

        <div class="skills mt-4">
            <div class="skill">
                <div class="icon">
                    <i class="fa-brands fa-linux"></i>
                </div>
                <div class="desc">
                    <h3>Administration Linux</h3>
                    <p>Gérant des serveurs fonctionnants sous Linux depuis de nombreuses années (2014), je n’éprouve
                        aucune difficulté à utiliser Linux au quotidien.</p>
                </div>
            </div>

            <div class="skill">
                <div class="icon">
                    <img src="{{ Vite::asset('resources/images/sofianelasri/Source Engine Logo.png') }}"
                         alt="Logo Source Engine"/>
                </div>
                <div class="desc">
                    <h3>Source engine (Hammer)</h3>
                    <p>Ayant fait du map making sur Garry’s Mod entre 2016 et 2020, j’ai acquis de bonnes connaissances
                        en ce qui concerne la création de maps. J’ai des connaissances poussées en optimisation, chose
                        très importante sur ce moteur assez capricieux.</p>
                </div>
            </div>

            <div class="skill">
                <div class="icon">
                    <i class="fa-brands fa-figma"></i>
                </div>
                <div class="desc">
                    <h3>Figma</h3>
                    <p>Comme précédemment expliqué, j’aime beaucoup réaliser des maquettes sur Figma. Aujourd’hui, je
                        peux prétendre pouvoir réaliser des maquettes à haute fidélité sans trop de difficultés.
                        <br>Toutefois, mon corps de métier n’étant ni le graphisme, ni le design, je peux passer
                        énormément de temps à concevoir une maquette.</p>
                </div>
            </div>

            <div class="skill">
                <div class="icon">
                    <i class="fa-solid fa-users-gear"></i>
                </div>
                <div class="desc">
                    <h3>Gestion de projet</h3>
                    <p>Ayant réalisé de nombreux projets par le passé, j’ai acquis une bonne base de connaissances en ce
                        qui concerne la gestion de projets. Mes cours à l’université m’ont également permis de renforcer
                        ces acquis.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="container">
        <h2 class="mb-4">Mon expérience profesionnelle</h2>

        <div class="skills">
            <div class="skill">
                <div class="icon">
                    <img src="{{ Vite::asset('resources/images/sofianelasri/kang_fr_dark.png') }}"
                         alt="Logo Kang.fr"/>
                </div>
                <div class="desc">
                    <h3 class="m-0">Développeur web Full-Stack</h3>
                    <div class="sub-title mb-2">
                        <a href="https://www.kang.fr/" target="_blank"
                           title="Visiter le site de mon employeur">Kang.fr</a> | Avril 2022 - Aujourd'hui
                    </div>
                    <p>D'abord embauché en tant que stagiaire pour valider mes deux années de DUT, j'y suis désormais
                        alternant. J'occupe le poste de développeur web Full-Stack, un rôle qui me correspond
                        parfaitement.</p>

                    <h5>Ma mission au sein de Kang :</h5>
                    <ul>
                        <li>Modernisation et migration d'anciennes interfaces, réalisées avec un framework maison, vers
                            Laravel.
                        </li>
                        <li>Création de composants graphique facilitant la création de nouvelles interfaces.</li>
                        <li>Implémentation de nouvelles fonctionnalités, sur demande, via le tableau sprint.</li>
                        <li>Maintenance des différents projets internes.</li>
                    </ul>

                    <h5>Compétances acquises :</h5>
                    <ul>
                        <li>Découverte du framework Laravel (ainsi que de son homologue Lumen).</li>
                        <li>Création et usage des tests unitaires avec PHPUnit.</li>
                        <li>Amélioration de mes connaissances en matière de gestion de projet.</li>
                        <li>Apprentissage des bonnes pratiques et conventions à respecter pour développer proprement.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
