<?php

namespace App\Http\Controllers;

use App\Http\Requests\CharacterIndexRequest;
use App\Services\RickAndMortyApi;
use Illuminate\View\View;

class FrontendController extends Controller
{
    public function index(CharacterIndexRequest $request, RickAndMortyApi $api): View
    {
        $characters = $api->search($request->filters(), $request->page())->withPath(route('encyclopaedia.get'));
        return view('encyclopaedia', [
            'characters' => $characters,
            'filters' => $request->filters()
        ]);

    }

}
