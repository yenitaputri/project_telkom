<?php
use App\Contracts\Interfaces\Eloquent\FindByUsernameInterface;

interface UserInterface extends FindByUsernameInterface, PasswordCheckerInterface, GetCountInterface
{
    public function create(array $data): \App\Models\User;
}
