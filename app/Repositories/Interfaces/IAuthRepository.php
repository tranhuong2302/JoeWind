<?php

namespace App\Repositories\Interfaces;

interface IAuthRepository
{
    public function login($credentials, $remember);

    public function register($credentials);
}
