<?php

namespace App\Http\Controllers;

use App\Services\CreateCombineLettersService;
use App\Services\FindWordDicionaryService;
use App\Services\FindWordLocalService;
use App\Services\RegisterWordService;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function __construct(Request $request)
    {
        $this->guestTerm($request->all());
    }

    public function guestTerm(array $data)
    {
        $combineService = new CreateCombineLettersService();

        $words = $combineService->execute(
            $data['word'],
            $data['notHas'],
            $data['has'],
            (isset($data['p'])) ? $data['p'] : []
        );

        $bingos = [];

        $findWordService = new FindWordLocalService();

        foreach ($words['words'] as $word) {
            if ($findWordService->findExistTerm($word)) {
                $bingos[] = $word;
            }
        }

        dd(["palavras válidas" => array_unique($bingos)]);
    }
}
