<?php

namespace App\Repositories\Interfaces\Admin;

use App\Repositories\Interfaces\IBaseRepository;

interface IAccountRepository extends IBaseRepository
{
    public function checkExistsByEmail($email);
}
