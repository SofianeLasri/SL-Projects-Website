<?php

namespace App\View\Components\Dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    private bool $sidebarOpened;
    public function __construct()
    {
        $this->sidebarOpened = request()->cookie('desktopOpenedSidebar') === 'true';

        if (! $this->sidebarOpened) {
            cookie()->queue('desktopOpenedSidebar', 'true', 60 * 24 * 30); // 30 jours
        }
    }

    public function render(): View
    {
        return view('components.dashboard.sidebar', [
            'sidebarOpened' => $this->sidebarOpened,
        ]);
    }
}
