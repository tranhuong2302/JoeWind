<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\RoleRequest;
use App\Repositories\Interfaces\Admin\IPermissionRepository;
use App\Repositories\Interfaces\Admin\IRoleRepository;
use App\Traits\ToastNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminRoleController extends Controller
{
    use ToastNotification;

    private $roleRepo;
    private $permissionRepo;

    public function __construct(IRoleRepository $roleRepository, IPermissionRepository $permissionRepository)
    {
        $this->roleRepo = $roleRepository;
        $this->permissionRepo = $permissionRepository;
    }

    public function index()
    {
        try {
            return view('admin.roles.index');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function create()
    {
        try {
            $permissionsParent = $this->permissionRepo->getPermissionRoots();
            return view('admin.roles.add', compact('permissionsParent'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function store(RoleRequest $request)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'name' => $request->get('name'),
                'display_name' => $request->get('display_name'),
            ];
            $createRole = $this->roleRepo->createData($data);
            $createRole->permissions()->attach($request->get('permission_id'));
            $this->toastSuccess("Create role success", "Success");
            DB::commit();
            return redirect()->route('roles.create');
        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error creating roles", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $permissionsParent = $this->permissionRepo->getPermissionRoots();
            $role = $this->roleRepo->findDataById($id);
            $permissionCheck = $role->permissions;
            return view('admin.roles.update', compact('permissionsParent', 'role', 'permissionCheck'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(RoleRequest $request, $id)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'name' => $request->get('name'),
                'display_name' => $request->get('display_name'),
            ];
            $updateRole = $this->roleRepo->updateDataById($id, $data);
            $updateRole->permissions()->sync($request->get('permission_id'));
            $this->toastSuccess("Update role success", "Success");
            DB::commit();
            return redirect()->route('roles.index');
        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error update roles", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
