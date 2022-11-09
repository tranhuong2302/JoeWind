<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\StorageImageTrait;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAccountController extends Controller
{
    use StorageImageTrait;
    private Permission $permission;
    private Role $role;
    private User $account;

    public function __construct(User $user,Role $role,Permission $permission){
        $this->account = $user;
        $this->role = $role;
        $this->permission = $permission;
    }
    public function index(){
        try {
            $accounts = $this->account->latest()->paginate(10);
            return view('admin.accounts.index', compact('accounts'));
        }
        catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    public function create(){
        try {
            return view('admin.accounts.add');
        }
        catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
    public function store(){
        try {
            return view('admin.accounts.add');
        }
        catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

}
