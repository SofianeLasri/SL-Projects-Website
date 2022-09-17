<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SteamUserProfile extends Model
{
    protected $primaryKey = 'steamid';
    public $incrementing = false;
    public $timestamps = false;

    static function get($steamId = null) : Collection
    {
        $instance = new static();
        if($steamId == null){
            $steamId = config('app.steam_profile_id64');
        }

        $steamUserProfileApiLink = "http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key="
            .config('app.steam_api_key')
            ."&steamids="
            .$steamId;

        $apiResponse = Http::get($steamUserProfileApiLink);
        if($apiResponse->status() == 200){
            $steamUserProfileInformations = Http::get($steamUserProfileApiLink)->collect()->get("response")["players"][0];

            if(!$instance->find($steamId)){
                $instance->insert($steamUserProfileInformations);
            }
        }else{
            $steamUserProfileInformations = $instance->find($steamId);
        }
        if($steamUserProfileInformations["avatarhash"] ===  config('app.steam_profile_avatar_hash')){
            $steamUserProfileInformations["avatarfull"] = "/images/steam/cornflakes-fullres.png";
        }
        return collect($steamUserProfileInformations);
    }
}
