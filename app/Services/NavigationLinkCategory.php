<?php

namespace App\Services;

use Cache;

class NavigationLinkCategory
{
    public String $title;
    public String $description;
    public array $children;

    public function __construct($title, $description, $children)
    {
        $this->title = $title;
        $this->description = $description;
        $this->children = array_map(fn($child) => new NavigationLinkChild($child), $children);
    }

    public static function all()
    {
        return Cache::remember('navigation_link_categories', now()->addHour(), function () {
            $categories = config('dashboard.navigation');
            return array_map(fn($category) => new self($category['title'], $category['description'], $category['children']), $categories);
        });
    }
}
