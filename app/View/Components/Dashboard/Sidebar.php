<?php

namespace App\View\Components\Dashboard;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
    private bool $sidebarOpened;

    public function __construct()
    {
        $sidebarOpenedCookieValue = request()->cookie('isDashboardSidebarOpened');

        if ($sidebarOpenedCookieValue === null) {
            cookie()->queue('isDashboardSidebarOpened', 'true', 60 * 24 * 30); // 30 jours
            $this->sidebarOpened = true;
        } else {
            $this->sidebarOpened = $sidebarOpenedCookieValue === 'true';
        }
    }

    public function render(): View
    {
        return view('components.dashboard.sidebar', [
            'sidebarOpened' => $this->sidebarOpened,
        ]);
    }
}
