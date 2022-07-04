<?php

namespace App\Services;

class CreateCombineLettersService
{
    public int $count = 0;

    public array $words = [];

    public array $letters =  ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "x", "z"];

    public function execute($word, $notHas, $has, $p): array
    {
        $this->removeLetters($notHas);

        $this->combineLetters($word, $p);

        $this->removeWordsNotHasChar($has);

        return [
            'count' => $this->count,
            'words' => $this->words
        ];
    }

    public function removeLetters(string $notHas): void
    {
        foreach ($this->letters as $index => $letter) {
            foreach (str_split($notHas) as $noLetter) {
                if ($letter === $noLetter) {
                    unset($this->letters[$index]);
                }
            }
        }
    }

    public function combineLetters(string $word, array $notIs): void
    {
        $letters = str_split($word);
        $combines = [];
        foreach ($letters as $i => $item) {
            if ($item != "*") {
                $combines[$i][] = $item;
                continue;
            }

            foreach ($this->letters as $letter) {
                $indexNotIs = $i + 1;
                if (isset($notIs[$indexNotIs])) {
                    $notCan = str_split($notIs[$indexNotIs]);
                    if (in_array($letter, $notCan)) {
                        continue;
                    }
                }
                $combines[$i][] = $letter;
            }
        }

        foreach ($combines[0] as $k1 => $r1) {
            foreach ($combines[1] as $k2 => $r2) {
                foreach ($combines[2] as $k3 => $r3) {
                    foreach ($combines[3] as $k4 => $r4) {
                        foreach ($combines[4] as $k5 => $r5) {
                            $this->words[] = $r1 . $r2 . $r3 . $r4 . $r5;
                            $this->count++;
                        }
                    }
                }
            }
        }
    }

    public function removeWordsNotHasChar(string $has): void
    {
        if (empty($has)) {
            return;
        }

        $has = str_split($has);
        foreach ($has as $letter) {
            foreach ($this->words as $key => $word) {
                if (strpos($word, $letter) === false) {
                    unset($this->words[$key]);
                }
            }
        }

        $this->count = count($this->words);
    }
}
