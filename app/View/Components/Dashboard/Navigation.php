<?php

namespace App\View\Components\Dashboard;

use App\Services\NavigationLinkCategory;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navigation extends Component
{
    public $categories;

    public function __construct()
    {
        $this->categories = NavigationLinkCategory::all();
    }

    public function render(): View
    {
        return view('components.dashboard.navigation', ['categories' => $this->categories]);
    }
}
