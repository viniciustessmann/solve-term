<?php

namespace App\Services;

class RegisterWordService
{
    public function registerWord(string $word): void
    {
        app('db')->insert('insert into terms (term) values (?)', [$word]);
    }

    public function registerNotWord(string $word): void
    {
        app('db')->insert('insert into not_terms (term) values (?)', [$word]);
    }
}
