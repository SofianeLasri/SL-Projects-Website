<?php

namespace App\Http\Controllers;

use App\Models\SteamUserProfile;
use Illuminate\Support\Facades\Http;

class VitrineController extends Controller
{
    public function index()
    {
        return view("websites.showcase.pages.home");
    }
}
