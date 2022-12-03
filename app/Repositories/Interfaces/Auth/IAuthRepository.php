<?php

namespace App\Repositories\Interfaces\Auth;

interface IAuthRepository
{
    public function login($credentials, $remember);

    public function register($credentials);

    public function logout();

    public function checkExistsByEmail($email);
}
