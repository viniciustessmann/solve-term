<?php

namespace App\Jobs;

use App\Services\FindWordDicionaryService;
use App\Services\RegisterWordService;
use GuzzleHttp\Client;

class ProcessWordJob extends Job
{
    public string $term;
    
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
        dump("Analisando a palavra: " . $this->term);

        $dicionaryService = new FindWordDicionaryService();

        $registerService = new RegisterWordService();

        $resultDicionary = $dicionaryService->search($this->term);

        if ($resultDicionary) {
            dump("Palavra existe");
            $registerService->registerWord($this->term);
        } else {
            dump("Palavra não existe");
            $registerService->registerNotWord($this->term);
        }
    }
}
