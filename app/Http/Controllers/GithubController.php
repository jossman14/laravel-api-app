<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GithubController extends Controller
{
    public function getApi(){
        $response = Http::withToken("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")->get("https://api.github.com/repos/jossman14/laravel-api-app");

        return json_decode($response);


    }
}
