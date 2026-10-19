<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Services\RickAndMortyApi;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function index(RickAndMortyApi $api): View
    {
        $data = $api->get('/character/', []);
        $characters = array_map(Character::fromApi(...), $data['results'] ?? []);
        return view('encyclopaedia')->with(compact('characters'));
    }

    public function test(RickAndMortyApi $api): View
    {
        $page = 1;
        $data = $api->get('/character', ['page' => $page]);
        print_r($data);
        die;
    }
}
