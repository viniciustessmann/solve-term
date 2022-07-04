<?php

namespace App\Services;

class FindWordLocalService
{
    public function find(string $word): int
    {
        if (!empty($this->findExistTerm($word))) {
            return 1;
        }

        if (!empty($this->findNotExistTerm($word))) {
            return 2;
        }

        return 0;
    }

    public function findExistTerm(string $word): bool
    {
        $result = app('db')->select("
            SELECT term 
            FROM terms 
            WHERE term = '" . $word ."' 
            LIMIT 1
        ");

        if (empty($result)) {
            return false;
        }

        return true;
    }

    public function findNotExistTerm(string $word): bool
    {
        $result = app('db')->select("
            SELECT term 
            FROM not_terms 
            WHERE term = '" . $word ."' 
            LIMIT 1
        ");

        if (empty($result)) {
            return false;
        }

        return true;
    }
}
