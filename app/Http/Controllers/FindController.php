<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTerms;
use App\Models\Term;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class FindController extends Controller
{
    public function __construct(Request $request)
    {
        $client = new Client();

        $result = $client->get('https://api.dicionario-aberto.net/word/' . strtolower($request->get('term')));

        $term = json_decode($result->getBody(), true);

        if (!empty($term)) {
            dd($term);
        }

        app('db')->insert('insert into not_terms (term) values (?)', [$request->get('term')]);
        dd('Ops!!!');
    }
}
