<?php

namespace App\Services;

use GuzzleHttp\Client;

class FindWordDicionaryService
{
    public function search(string $word): bool
    {
        $client = new Client();

        $result = $client->get('https://api.dicionario-aberto.net/word/' . strtolower($word));

        $term = json_decode($result->getBody(), true);

        if (empty($term)) {
            return false;
        }

        return true;
    }
}
