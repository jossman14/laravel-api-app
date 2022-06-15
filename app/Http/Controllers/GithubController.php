<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GithubController extends Controller
{
    public function getApi(){
        $response = Http::withToken(env("GITHUB_KEY", ""))->get("https://api.github.com/repos/jossman14/laravel-api-app");

        return json_decode($response);


    }
}
