<?php

return [
    'navigation' => [
        [
            'title' => 'Administration',
            'description' => 'Pages relatives à la gestion interne',
            'children' => [
                [
                    'title' => 'Accueil',
                    'url' => 'dashboard.home',
                    'icon' => 'fa-solid fa-house',
                ],
                [
                    'title' => 'Paramètres',
                    'icon' => 'fa-solid fa-gear',
                    'links' => [
                        ['title' => 'Paramètre 1', 'url' => '#', 'icon' => 'icon1'],
                        ['title' => 'Paramètre 2', 'url' => '#', 'icon' => 'icon2'],
                    ],
                ],
                [
                    'title' => 'Utilisateurs',
                    'icon' => 'fa-solid fa-users',
                    'links' => [
                        ['title' => 'Lien 1', 'url' => '#', 'icon' => 'icon1'],
                        ['title' => 'Lien 2', 'url' => '#', 'icon' => 'icon2'],
                    ],
                ],
                [
                    'title' => 'Médias',
                    'description' => 'Bibliothèque de médias',
                    'url' => 'dashboard.media-library.page',
                    'icon' => 'fa-solid fa-photo-film',
                ],
            ],
        ],
        [
            'title' => 'Sites',
            'description' => 'Sites internet liés',
            'children' => [
                [
                    'title' => 'Vitrine',
                    'icon' => 'fa-solid fa-gem',
                    'links' => [
                        [
                            'title' => 'Ajouter un projet',
                            'description' => 'Ajouter un projet à la vitrine',
                            'url' => 'dashboard.projects.add',
                            'icon' => 'fa-solid fa-circle-plus',
                        ],
                        ['title' => 'Lien 2', 'url' => '#', 'icon' => 'icon2'],
                    ],
                ],
                [
                    'title' => 'Blog',
                    'icon' => 'fa-solid fa-blog',
                    'links' => [
                        ['title' => 'Lien 1', 'url' => '#', 'icon' => 'icon1'],
                        ['title' => 'Lien 2', 'url' => '#', 'icon' => 'icon2'],
                    ],
                ],
            ],
        ],
    ],
];
