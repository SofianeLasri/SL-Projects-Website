<?php

namespace App\Http\Controllers\Showcase;

use App\Http\Controllers\Controller;

class VitrineController extends Controller
{
    public function index()
    {
        return view('websites.showcase.pages.home');
    }
}
