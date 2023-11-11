<?php

namespace App\Services\Dashboard;

class NavigationLinkChild
{
    public string $id;

    public string $title;

    public string $url;

    public array $links;

    public string $icon;

    public bool $isGroup = false;

    public function __construct($child)
    {
        $this->id = 'nav-link-'.uniqid();
        $this->title = $child['title'];
        $this->url = $child['url'] ?? '#'; // Utilisation de l'opérateur de coalescence null
        $this->icon = $child['icon'] ?? '';
        $this->description = $child['description'] ?? '';
        $this->links = array_map(fn ($link) => new self($link), $child['links'] ?? []);
        $this->isGroup = ! empty($this->links);
    }
}
