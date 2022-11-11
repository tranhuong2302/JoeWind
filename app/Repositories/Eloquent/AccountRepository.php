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

    public function getAccounts()
    {
        return $this->account->all();
    }

    public function createAccount($request)
    {
        return $this->account->create($request);
    }

    public function getAccountById($id)
    {
        return $this->account->find($id);
    }

    public function updateAccountById($id, $request)
    {
        return $this->account->find($id)->update($request);
    }

    public function changePassword($id, $request)
    {
        return $this->account->find($id)->update(['password' => $request]);
    }

    public function deleteAccountById($id)
    {
        return $this->account->find($id)->delete();
    }

    public function deleteMultipleAccount($ids)
    {
        return $this->account->whereIn('id', $ids)->delete();
    }
}
