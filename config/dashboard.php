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
                    'icon' => 'fa-solid fa-house'
                ],
                [
                    'title' => 'Paramètres',
                    'icon' => 'fa-solid fa-gear',
                    'links' => [
                        ['title' => 'Paramètre 1', 'url' => 'url1', 'icon' => 'icon1'],
                        ['title' => 'Paramètre 2', 'url' => 'url2', 'icon' => 'icon2'],
                    ]
                ],
                [
                    'title' => 'Utilisateurs',
                    'icon' => 'fa-solid fa-users',
                    'links' => [
                        ['title' => 'Lien 1', 'url' => 'dashboard.home', 'icon' => 'icon1'],
                        ['title' => 'Lien 2', 'url' => 'url2', 'icon' => 'icon2'],
                    ]
                ],
            ]
        ],
        [
            'title' => 'Sites',
            'description' => 'Sites internet liés',
            'children' => [
                [
                    'title' => 'Vitrine',
                    'icon' => 'fa-solid fa-gem',
                    'links' => [
                        ['title' => 'Lien 1', 'url' => 'url1', 'icon' => 'icon1'],
                        ['title' => 'Lien 2', 'url' => 'url2', 'icon' => 'icon2'],
                    ]
                ],
                [
                    'title' => 'Blog',
                    'icon' => 'fa-solid fa-blog',
                    'links' => [
                        ['title' => 'Lien 1', 'url' => 'url1', 'icon' => 'icon1'],
                        ['title' => 'Lien 2', 'url' => 'url2', 'icon' => 'icon2'],
                    ]
                ],
            ]
        ],
    ],
];
