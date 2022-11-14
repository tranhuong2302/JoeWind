<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\User;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Interfaces\Admin\IAccountRepository;

class EloquentAccountRepository extends EloquentBaseRepository implements IAccountRepository
{

    protected $account;

    public function __construct(User $account)
    {
        parent::__construct($account);
        $this->account = $account;
    }

    public function changePassword($id, $request)
    {
        $data = $this->account->find($id);
        if($data){
            $data->update(['password' => $request]);
            return $data;
        }
        return false;
    }

}
