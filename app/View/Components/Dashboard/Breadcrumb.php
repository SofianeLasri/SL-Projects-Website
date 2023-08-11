<?php

namespace App\View\Components\Dashboard;

use App\Services\NavigationLinkCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public $breadcrumbs;

    public function __construct()
    {
        $this->breadcrumbs = $this->buildBreadcrumbs();
    }

    public function render(): View
    {
        return view('components.dashboard.breadcrumb', [
            'breadcrumbs' => $this->breadcrumbs,
            'sidebarOpened' => request()->cookie('desktopOpenedSidebar') === 'true',
        ]);
    }

    private function buildBreadcrumbs()
    {
        $currentUrl = url()->current();
        $breadcrumbs = [];

        // Obtenez toutes les catégories et parcourrez-les pour trouver l'URL actuelle
        foreach (NavigationLinkCategory::all() as $category) {
            foreach ($category->children as $child) {
                if (! empty($child->links)) {
                    foreach ($child->links as $link) {
                        if ($this->isMatchingUrl($currentUrl, $link->url)) {
                            $breadcrumbs[] = ['name' => $category->title, 'url' => '#'];
                            $breadcrumbs[] = ['name' => $child->title, 'url' => '#'];
                            $breadcrumbs[] = ['name' => $link->title, 'url' => $this->resolveUrl($link->url)];
                            break 3; // Sortez des boucles si vous avez trouvé le lien
                        }
                    }
                } else {
                    if ($this->isMatchingUrl($currentUrl, $child->url)) {
                        $breadcrumbs[] = ['name' => $category->title, 'url' => '#'];
                        $breadcrumbs[] = ['name' => $child->title, 'url' => $this->resolveUrl($child->url)];
                        break 2; // Sortez des boucles si vous avez trouvé le lien
                    }
                }
            }
        }

        return $breadcrumbs;
    }

    private function resolveUrl($url)
    {
        if (Route::has($url)) {
            return route($url);
        } else {
            return $url;
        }
    }

    private function isMatchingUrl($currentUrl, $url)
    {
        return $currentUrl == $this->resolveUrl($url);
    }
}
