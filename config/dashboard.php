<?php

return [
    'navigation' => [
        [
            'id' => 'administration',
            'title' => 'Administration',
            'description' => 'Pages relatives à la gestion interne',

        ],
        [
            'id' => 'home',
            'title' => 'Accueil',
            'description' => "Page d'accueil du panneau d'administration",
            'icon' => 'fa-solid fa-house',
            'route' => 'dashboard.home',
            'parent' => 'administration',
        ],
        [
            'id' => 'settings',
            'title' => 'Paramètres',
            'description' => 'Paramètres internes de SL-Projects',
            'icon' => 'fa-solid fa-gear',
            'parent' => 'administration',
        ],
        [
            'id' => 'fake-child1',
            'title' => 'Placeholder 1',
            'description' => 'Description placeholder',
            'icon' => 'fa-solid fa-question',
            'parent' => 'settings',
        ],
        [
            'id' => 'fake-child2',
            'title' => 'Placeholder 2',
            'description' => 'Description placeholder',
            'icon' => 'fa-solid fa-question',
            'children' => null,
            'parent' => 'settings',
        ],
        [
            'id' => 'fake-child3',
            'title' => 'Placeholder 3',
            'description' => 'Description placeholder',
            'icon' => 'fa-solid fa-question',
            'children' => null,
            'parent' => 'settings',
        ],
        [
            'id' => 'users',
            'title' => 'Utilisateurs',
            'description' => 'Gérer les comptes utilisateurs de SL-Projets',
            'icon' => 'fa-solid fa-users',
            'parent' => 'administration',
        ],
        [
            'id' => 'fake-child4',
            'title' => 'Placeholder 4',
            'description' => 'Description placeholder',
            'icon' => 'fa-solid fa-question',
            'children' => null,
            'parent' => 'users',
        ],
        [
            'id' => 'fake-child5',
            'title' => 'Placeholder 5',
            'description' => 'Description placeholder',
            'icon' => 'fa-solid fa-question',
            'children' => null,
            'parent' => 'users',
        ],
        [
            'id' => 'fake-child6',
            'title' => 'Placeholder 6',
            'description' => 'Description placeholder',
            'icon' => 'fa-solid fa-question',
            'children' => null,
            'parent' => 'users',
        ],
        [
            'id' => 'websites',
            'title' => 'Sites',
            'description' => 'Sites internet liés',

        ],
        [
            'id' => 'showcase',
            'title' => 'Vitrine',
            'description' => 'Vitrine de SL-Projects',
            'icon' => 'fa-solid fa-gem',
            'parent' => 'websites',
        ],
        [
            'id' => 'fake-child7',
            'title' => 'Placeholder 7',
            'description' => 'Description placeholder',
            'icon' => 'fa-solid fa-question',
            'parent' => 'showcase',
        ],
        [
            'id' => 'fake-child8',
            'title' => 'Placeholder 8',
            'description' => 'Description placeholder',
            'icon' => 'fa-solid fa-question',
            'parent' => 'showcase',
        ],
        [
            'id' => 'blog',
            'title' => 'Blog',
            'description' => 'Blog de SL-Projects',
            'icon' => 'fa-solid fa-blog',

        ],
        [
            'id' => 'fake-child9',
            'title' => 'Placeholder 9',
            'description' => 'Description placeholder',
            'icon' => 'fa-solid fa-question',
            'parent' => 'blog',
        ],
        [
            'id' => 'fake-child10',
            'title' => 'Placeholder 10',
            'description' => 'Description placeholder',
            'icon' => 'fa-solid fa-question',
            'parent' => 'blog',
        ],
    ],
];
