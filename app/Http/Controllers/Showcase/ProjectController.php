<?php

namespace App\Http\Controllers\Showcase;

use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    public function index()
    {
        return view('websites.showcase.pages.project');
    }
}
