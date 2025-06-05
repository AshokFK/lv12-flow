<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;

class Operator 
{
    public static function search($term)
    {
        $response = Http::withToken(env('API_TOKEN'))->get(env('API_SPISY') . "?q={$term}&type=flow&status=active");
        return $response->json();
    }

    public static function nik($nik)
    {
        $response = Http::withToken(env('API_TOKEN'))->get(env('API_SPISY') . "/{$nik}");
        return $response->json();
    }

}
