<?php

namespace App\Services;

use Illuminate\Support\Facades\Route;

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
        $this->id = "nav-link-" . uniqid();
        $this->title = $child['title'];
        $this->url = !empty($child['url']) ? $child['url'] : '#';
        $this->icon = $child['icon'] ?? '';

        if (!empty($child['links'])) {
            $this->isGroup = true;
            $this->links = array_map(fn($link) => new self($link), $child['links']);
        } else {
            $this->links = [];
        }
    }
}
