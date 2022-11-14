<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permission\PermissionRequest;
use App\Repositories\Interfaces\Admin\IPermissionRepository;
use App\Traits\ToastNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminPermissionController extends Controller
{
    use ToastNotification;

    private $permissionRepo;

    public function __construct(IPermissionRepository $permissionRepository)
    {
        $this->permissionRepo = $permissionRepository;
    }

    public function index()
    {
        try {
            $html = $this->permissionRepo->getDataTableRecursivePermissions();
            return view('admin.permissions.index', compact('html'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    public function create()
    {
        try {
            $htmlOptions = $this->permissionRepo->getSelectRecursivePermissions(0);
            return view('admin.permissions.add', compact('htmlOptions'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function store(PermissionRequest $request)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'name' => $request->get('name'),
                'display_name' => $request->get('display_name'),
                'parent_id' => $request->get('parent_id'),
                'keycode' => Str::slug($request->get('name'))
            ];
            $permission = $this->permissionRepo->createData($data);
            if ($permission) {
                $this->toastSuccess("Create permission success", "Success");
                DB::commit();
                return redirect()->route('permissions.create');
            } else  return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error creating permission", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $permission = $this->permissionRepo->findDataById($id);
            $htmlOptions = $this->permissionRepo->getSelectRecursivePermissions($permission->parent_id);
            return view('admin.permissions.update', compact('permission', 'htmlOptions'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(PermissionRequest $request, $id)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'name' => $request->get('name'),
                'display_name' => $request->get('display_name'),
                'parent_id' => $request->get('parent_id'),
                'keycode' => Str::slug($request->get('name'))
            ];
            $permission = $this->permissionRepo->updateDataById($id, $data);
            if ($permission) {
                $this->toastSuccess("Updated permission successfully", "Success");
                DB::commit();
                return redirect()->route('permissions.index');
            } else  return redirect()->back();

        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error updating permission", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
