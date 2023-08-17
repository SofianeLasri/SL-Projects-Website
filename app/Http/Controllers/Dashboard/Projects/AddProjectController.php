<?php

namespace App\Http\Controllers\Dashboard\Projects;

use App\Http\Controllers\Controller;

class AddProjectController extends Controller
{
    public function index()
    {
        return view('websites.dashboard.projects.add-project');
    }
}
