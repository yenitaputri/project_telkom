<?php
namespace App\Contracts\Interfaces\Eloquent;

interface FindByUsernameInterface
{
    public function findByUsername(string $username);
}
