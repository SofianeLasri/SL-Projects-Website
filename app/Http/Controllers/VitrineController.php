<?php

namespace App\Http\Controllers;

use App\Models\SteamUserProfile;
use Illuminate\Support\Facades\Http;

class VitrineController extends Controller
{
    public function index()
    {
        $cornflakesSteamProfile = SteamUserProfile::get();
        $workshopItems = [
            [
                "id" => 1849444176,
                "name" => "GTA IV : TBoGT - Maisonette 9",
                "stars" => 5,
                "votes" => 425,
                "published_date" => "30/08/2019 17H45",
                "updated_date" => "02/09/2019 14H55"
            ],
            [
                "id" => 1782967195,
                "name" => "Starisland Map Finale",
                "stars" => 5,
                "votes" => 281,
                "published_date" => "27/06/2019 19H34",
                "updated_date" => "27/06/2022 11H43"
            ],
            [
                "id" => 2003231810,
                "name" => "Scene Ocean Dr",
                "stars" => 4,
                "votes" => 92,
                "published_date" => "21/02/2020 11H56",
                "updated_date" => null
            ],
            [
                "id" => 1681654378,
                "name" => "Hawking National Laboratory",
                "stars" => 4,
                "votes" => 66,
                "published_date" => "13/03/2019 14H56",
                "updated_date" => "13/03/2019 15H27"
            ],
            [
                "id" => 1904537279,
                "name" => "[PHYS] Worst Elevator EVER MADE",
                "stars" => 4,
                "votes" => 106,
                "published_date" => "02/11/2019 11H14",
                "updated_date" => null
            ]
        ];
        return view("vitrine", ['steamUserProfileInformations' => $cornflakesSteamProfile, 'workshopItems' => $workshopItems]);
    }
}
