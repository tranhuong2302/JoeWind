<?php

namespace App\Repositories\Interfaces;

interface IAccountRepository
{
    public function getAccounts();

    public function createAccount($request);

    public function getAccountById($id);

    public function updateAccountById($id,$request);

    public function changePassword($id, $request);

    public function deleteAccountById($id);

    public function deleteMultipleAccount($ids);
}
