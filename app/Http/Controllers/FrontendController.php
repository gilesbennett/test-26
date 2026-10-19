<?php

namespace App\Http\Controllers;

use App\Services\RickAndMortyApi;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function index(Request $request): View
    {
        return view('encyclopaedia');
    }

    public function test(RickAndMortyApi $api): View
    {
        $page = 1;
        $data = $api->get('/character', ['page' => $page]);
        print_r($data);
        die;
    }
}
