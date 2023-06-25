<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RobotsTxtController extends Controller
{
    public function index(Request $request)
    {
        if (config("app.env") !== "production" ||
            in_array(
                $request->host(),
                [
                    config("app.domain.auth"),
                    config("app.domain.dashboard"),
                    config("app.domain.api")
                ]
            )
        ) {
            $robotFile = view('robots-disallow');
            return response($robotFile)->header('Content-Type', 'text/plain');
        }
        $robotFile = view('robots-allow');
        return response($robotFile)->header('Content-Type', 'text/plain');
    }
}
