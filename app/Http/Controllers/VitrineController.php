<?php

namespace App\Http\Controllers;

class VitrineController extends Controller
{
    public function index()
    {
        return view('websites.showcase.pages.home');
    }
}
