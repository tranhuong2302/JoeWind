<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Permission\PermissionRequest;
use App\Repositories\Interfaces\Admin\IPermissionRepository;
use App\Traits\ApiResponse;
use App\Traits\ToastNotification;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;

class AdminPermissionController extends Controller
{
    use ToastNotification;
    use ApiResponse;

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
                'name' => $request->input('name'),
                'display_name' => $request->input('display_name'),
                'parent_id' => $request->input('parent_id'),
                'keycode' => Str::slug($request->input('name'))
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
                'name' => $request->input('name'),
                'display_name' => $request->input('display_name'),
                'parent_id' => $request->input('parent_id'),
                'keycode' => Str::slug($request->input('name'))
            ];
            if ($this->permissionRepo->checkUpdatePermissionToChild($request->input('parent_id'), $id)) {
                $this->toastWarning("Unable to edit permission on its children", "Warning");
                return redirect()->back();
            } else if ($this->permissionRepo->checkUpdatePermissionToItSelf($request->input('parent_id'), $id)) {
                $this->toastWarning("Unable to edit permission on it self", "Warning");
                return redirect()->back();
            } else $permission = $this->permissionRepo->updateDataById($id, $data);
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

    public function deletePermissionById($id)
    {
        try {
            $this->permissionRepo->deleteDataById($id);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete permission success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function deleteSelected(Request $request)
    {
        try {
            $ids = $request->get('ids');
            $this->permissionRepo->deleteMultipleData($ids);
            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Delete selected permissions success',
            ], 200);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
