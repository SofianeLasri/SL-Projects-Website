<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class FilemanagerController extends Controller
{
    public function index()
    {
        return view('websites.dashboard.filemanager');
    }
}
