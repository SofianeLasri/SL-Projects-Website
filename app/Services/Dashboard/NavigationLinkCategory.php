<?php

namespace App\Services\Dashboard;

use Cache;

class NavigationLinkCategory
{
    public string $title;

    public string $description;

    public array $children;

    /**
     * Créez une nouvelle instance de NavigationLinkCategory.
     *
     * @param  string  $title Titre de la catégorie
     * @param  string  $description Description de la catégorie
     * @param  array  $children Liste de liens enfants
     */
    public function __construct($title, $description, $children)
    {
        $this->title = $title;
        $this->description = $description;
        $this->children = array_map(fn ($child) => new NavigationLinkChild($child), $children);
    }

    /**
     * Obtenez toutes les catégories de liens de navigation.
     */
    public static function all(): array
    {
        return Cache::remember('navigation_link_categories', now()->addHour(), function () {
            $categories = config('dashboard.navigation');

            return array_map(fn ($category) => new self($category['title'], $category['description'], $category['children']), $categories);
        });
    }
}
