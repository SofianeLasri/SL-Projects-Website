<?php

namespace App\View\Components\Dashboard;

use App\Services\Dashboard\NavigationLinkCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public array $breadcrumbs;

    private string $pageTitle;

    private string $pageDescription;

    private string $pageIcon;

    public bool $disableHeader = false;

    public function __construct(bool $disableHeader = false)
    {
        $this->disableHeader = $disableHeader;
        $this->breadcrumbs = $this->buildBreadcrumbs();
        $this->pageTitle = $this->breadcrumbs[count($this->breadcrumbs) - 1]['name'];
        $this->pageDescription = $this->breadcrumbs[count($this->breadcrumbs) - 1]['description'] ?? '';
        $this->pageIcon = $this->breadcrumbs[count($this->breadcrumbs) - 1]['icon'] ?? '';
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
                            $breadcrumbs[] = [
                                'name' => $link->title,
                                'url' => $this->resolveUrl($link->url),
                                'icon' => $link->icon,
                                'description' => $link->description ?? '',
                            ];
                            break 3; // Sortez des boucles si vous avez trouvé le lien
                        }
                    }
                } else {
                    if ($this->isMatchingUrl($currentUrl, $child->url)) {
                        $breadcrumbs[] = ['name' => $category->title, 'url' => '#'];
                        $breadcrumbs[] = [
                            'name' => $child->title,
                            'url' => $this->resolveUrl($child->url),
                            'icon' => $child->icon,
                            'description' => $child->description ?? '',
                        ];
                        break 2; // Sortez des boucles si vous avez trouvé le lien
                    }
                }
            }
        }

        return $breadcrumbs;
    }

    private function isMatchingUrl($currentUrl, $url)
    {
        return $currentUrl == $this->resolveUrl($url);
    }

    private function resolveUrl($url)
    {
        if (Route::has($url)) {
            return route($url);
        } else {
            return $url;
        }
    }

    public function render(): View
    {
        $sidebarOpenedCookieValue = request()->cookie('isDashboardSidebarOpened');
        if ($sidebarOpenedCookieValue === null) {
            $sidebarOpened = true;
        } else {
            $sidebarOpened = $sidebarOpenedCookieValue === 'true';
        }

        return view('components.dashboard.breadcrumb', [
            'breadcrumbs' => $this->breadcrumbs,
            'sidebarOpened' => $sidebarOpened,
            'pageTitle' => $this->pageTitle,
            'pageIcon' => $this->pageIcon,
            'pageDescription' => $this->pageDescription,
        ]);
    }
}
