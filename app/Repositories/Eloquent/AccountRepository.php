<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\IAccountRepository;

class AccountRepository implements IAccountRepository
{
    protected $account;

    public function __construct(User $user)
    {
        $this->account = $user;
    }

    public function createAccount($data)
    {
        return $this->account->create($data);
    }
}
