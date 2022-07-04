<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTerms;
use App\Models\Term;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ProcessController extends Controller
{
    public function __construct(Request $request)
    {
        $this->guestTerm($request->all());
    }

    public function guestTerm(array $data)
    {
        $notHasString = str_split($data['notHas']);

        $result = [];

        $letters = ["A", "ã", "B", "C", "D", "E", "é", "F", "G", "H", "I", "J", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "X", "Z"];

        foreach ($notHasString as $notHas) {
            foreach ($letters as $key => $item) {
                if ($notHas == $item) {
                    unset($letters[$key]);
                }
            }
        }

        $term = str_split($data['term']);
        $result[1] = $term[0];
        $result[2] = $term[1];
        $result[3] = $term[2];
        $result[4] = $term[3];
        $result[5] = $term[4];

        $guest = [];
        foreach ($result as $i => $item) {
            if ($item != "*") {
                $guest[$i][] = $item;
                continue;
            }

            foreach ($letters as $letter) {
                $guest[$i][] = $letter;
            }
        }

        $words = [];
        $count = 0;
        foreach ($guest[1] as $k1 => $r1) {
            foreach ($guest[2] as $k2 => $r2) {
                foreach ($guest[3] as $k3 => $r3) {
                    foreach ($guest[4] as $k4 => $r4) {
                        foreach ($guest[5] as $k5 => $r5) {
                            $words[] = $r1 . $r2 . $r3 . $r4 . $r5;
                            $count++;
                        }
                    }
                }
            }
        }

        $bingos = [];
    
        foreach ($words as $word) {
            dispatch(new ProcessTerms(strtolower($word)));
        }

        dd($bingos);
    }
}
