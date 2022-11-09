<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\IAuthRepository;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements IAuthRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login($credentials, $remember)
    {
        return Auth::attempt($credentials, $remember);
    }

    public function register($credentials)
    {
        return $this->user->create($credentials);
    }
}
