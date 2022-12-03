<?php

namespace App\Repositories\Eloquent\Admin;

use App\Models\User;
use App\Repositories\Eloquent\EloquentBaseRepository;
use App\Repositories\Interfaces\Admin\IAccountRepository;

class EloquentAccountRepository extends EloquentBaseRepository implements IAccountRepository
{

    private User $account;

    public function __construct(User $account)
    {
        parent::__construct($account);
        $this->account = $account;
    }

    public function checkExistsByEmail($email)
    {
        return $this->account->where('email', $email)->first();
    }

}
