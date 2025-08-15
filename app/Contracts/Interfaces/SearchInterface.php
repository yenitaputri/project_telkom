<?php

namespace App\Contracts\Interfaces;

interface SearchInterface
{
    public function search(string $keyword): array;
}
