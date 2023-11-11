<?php

namespace App\Http\Controllers\SofianeLasri;

use App\Http\Controllers\Controller;
use App\Services\BrowserSupport;
class IndexController extends Controller
{
    public function index()
    {
        return view('websites.sofianelasri.pages.index');
    }
}
