<?php

return [
    'navigation' => [
        'administration' => [
            'title' => 'Administration',
            'description' => 'Pages relatives à la gestion interne',
            'icon' => null,
            'route' => null,
            'children' => [
                'home' => [
                    'title' => 'Accueil',
                    'description' => "Page d'accueil du panneau d'administration",
                    'icon' => 'fa-solid fa-house',
                    'route' => 'dashboard.home',
                    'children' => null,
                ],
                'settings' => [
                    'title' => 'Paramètres',
                    'description' => 'Paramètres internes de SL-Projects',
                    'icon' => 'fa-solid fa-gear',
                    'route' => null,
                    'children' => [
                        'fake-child1' => [
                            'title' => 'Placeholder 1',
                            'description' => 'Description placeholder',
                            'icon' => 'fa-solid fa-question',
                            'route' => null,
                            'children' => null,
                        ],
                        'fake-child2' => [
                            'title' => 'Placeholder 2',
                            'description' => 'Description placeholder',
                            'icon' => 'fa-solid fa-question',
                            'route' => null,
                            'children' => null,
                        ],
                        'fake-child3' => [
                            'title' => 'Placeholder 3',
                            'description' => 'Description placeholder',
                            'icon' => 'fa-solid fa-question',
                            'route' => null,
                            'children' => null,
                        ],
                    ],
                ],
                'users' => [
                    'title' => 'Utilisateurs',
                    'description' => 'Gérer les comptes utilisateurs de SL-Projets',
                    'icon' => 'fa-solid fa-users',
                    'route' => null,
                    'children' => [
                        'fake-child4' => [
                            'title' => 'Placeholder 4',
                            'description' => 'Description placeholder',
                            'icon' => 'fa-solid fa-question',
                            'route' => null,
                            'children' => null,
                        ],
                        'fake-child5' => [
                            'title' => 'Placeholder 5',
                            'description' => 'Description placeholder',
                            'icon' => 'fa-solid fa-question',
                            'route' => null,
                            'children' => null,
                        ],
                        'fake-child6' => [
                            'title' => 'Placeholder 6',
                            'description' => 'Description placeholder',
                            'icon' => 'fa-solid fa-question',
                            'route' => null,
                            'children' => null,
                        ],
                    ],
                ],
            ],
        ],
        'websites' => [
            'title' => 'Sites',
            'description' => 'Sites internet liés',
            'icon' => null,
            'route' => null,
            'children' => [
                'showcase' => [
                    'title' => 'Vitrine',
                    'description' => 'Vitrine de SL-Projects',
                    'icon' => 'fa-solid fa-gem',
                    'route' => null,
                    'children' => [
                        'fake-child7' => [
                            'title' => 'Placeholder 7',
                            'description' => 'Description placeholder',
                            'icon' => 'fa-solid fa-question',
                            'route' => null,
                            'children' => null,
                        ],
                        'fake-child8' => [
                            'title' => 'Placeholder 8',
                            'description' => 'Description placeholder',
                            'icon' => 'fa-solid fa-question',
                            'route' => null,
                            'children' => null,
                        ],
                    ],
                ],
                'blog' => [
                    'title' => 'Blog',
                    'description' => 'Blog de SL-Projects',
                    'icon' => 'fa-solid fa-blog',
                    'route' => null,
                    'children' => [
                        'fake-child9' => [
                            'title' => 'Placeholder 9',
                            'description' => 'Description placeholder',
                            'icon' => 'fa-solid fa-question',
                            'route' => null,
                            'children' => null,
                        ],
                        'fake-child10' => [
                            'title' => 'Placeholder 10',
                            'description' => 'Description placeholder',
                            'icon' => 'fa-solid fa-question',
                            'route' => null,
                            'children' => null,
                        ],
                    ],
                ],
            ],
        ],
    ],
];
