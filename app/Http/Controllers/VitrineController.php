<?php

namespace App\Http\Controllers;

use App\Models\SteamUserProfile;
use Illuminate\Support\Facades\Http;

class VitrineController extends Controller
{
    public function index()
    {
        $cornflakesSteamProfile = SteamUserProfile::get();
        return view("vitrine", ['steamUserProfileInformations' => $cornflakesSteamProfile]);
    }
}
