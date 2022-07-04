<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessWordJob;
use App\Services\CreateCombineLettersService;
use App\Services\FindWordDicionaryService;
use App\Services\FindWordLocalService;
use App\Services\RegisterWordService;
use Illuminate\Http\Request;

class RunController extends Controller
{
    public function __construct(Request $request)
    {
        $combineService =  new CreateCombineLettersService();

        $result = $combineService->execute(
            $request->get('word'),
            $request->get('notHas'),
            $request->get('has'),
            $request->get('p', [])
        );

        $findWordService = new FindWordLocalService();

        $dicionaryService = new FindWordDicionaryService();

        $registerService = new RegisterWordService();

        $success = [];
        $countWords = 0;
        $countNotWords = 0;
        $countFindWords = 0;

        foreach ($result['words'] as $word) {
            $codeFindWord = $findWordService->find($word);

            if ($codeFindWord === 1) {
                $countWords++;
                $success[] = $word;
            }

            if ($codeFindWord === 2) {
                $countNotWords++;
            }

            if ($codeFindWord === 0) {
                $countFindWords++;
                if ($request->get('queue')) {
                    dispatch(new ProcessWordJob($word));
                }
            }
        }

        $response = [
            "Combinações de palavras" => $result['count'],
            "Palavras encontradas no banco de dados" => $countWords,
            "Palavras não válidas encontradas no banco de dados" => $countNotWords,
            "Palavras para serem analisadas" => $countFindWords
        ];

        dd($response);
    }
}
