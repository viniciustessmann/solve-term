<?php

namespace App\Jobs;

use GuzzleHttp\Client;

class ProcessTerms extends Job
{
    public string $term;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $term)
    {
        $this->term = $term;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $word = $this->term;

        dump('Palavra: ' . $word);

        dump('https://api.dicionario-aberto.net/word/' . strtolower($word));

        $client = new Client();

        $result = $client->get('https://api.dicionario-aberto.net/word/' . strtolower($word));

        $term = json_decode($result->getBody(), true);

        if (!empty($term)) {
            $this->insertDatabase(strtolower($word));
        } else {
            $this->insertNotTermDatabase($word);
        }
    }

    public function findOnDatabase($term)
    {
        $term = strtolower($term);
        $results = app('db')->select("SELECT term FROM terms WHERE term like '%". $term ."%' LIMIT 1");
        if (isset($results[0]->term)) {
            return $results[0]->term;
        } else {
            $this->insertNotTermDatabase(strtolower($word));
        }

        return false;
    }

    public function findNotTermOnDatabase($term)
    {
        $results = app('db')->select("SELECT term FROM not_terms WHERE term like '%". $term ."%' LIMIT 1");
        if (isset($results[0]->term)) {
            return $results[0]->term;
        }

        return false;
    }

    public function insertDatabase($term)
    {
        $term = strtolower($term);
        app('db')->insert('insert into terms (term) values (?)', [$term]);
    }

    public function insertNotTermDatabase($term)
    {
        $term = strtolower($term);
        app('db')->insert('insert into not_terms (term) values (?)', [$term]);
    }
}
