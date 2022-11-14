<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Account\AccountRequest;
use App\Repositories\Interfaces\Admin\IAccountRepository;
use App\Repositories\Interfaces\Admin\IRoleRepository;
use App\Traits\ToastNotification;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Request;

class AdminAccountController extends Controller
{
    use MediaAlly;
    use ToastNotification;

    private $accountRepo;
    private $roleRepo;

    public function __construct(IAccountRepository $accountRepo, IRoleRepository $roleRepo)
    {
        $this->accountRepo = $accountRepo;
        $this->roleRepo = $roleRepo;
    }

    public function index()
    {
        try {
            return view('admin.accounts.index');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    public function create()
    {
        try {
            $roles = $this->roleRepo->getAll();
            return view('admin.accounts.add', compact('roles'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function store(AccountRequest $request)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make(1),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
                'status' => $request->get('status'),
            ];
            $image_path = $request->hasFile('image_path');
            if ($image_path) {
                // Upload an Image File to Cloudinary with One line of Code
                $uploadedFileUrl = Cloudinary::upload($request->file('image_path')->getRealPath(), [
                    'folder' => 'Account',
                ])->getSecurePath();
                if (!empty($uploadedFileUrl)) {
                    $data['image_path'] = $uploadedFileUrl;
                }
            }
            $account = $this->accountRepo->createData($data);
            //2 cách thêm mảng
            $roleIds = $request->get('role_id');
            // C1 truyền thống
            // foreach ($roleIds as $roleItem) {
            //     DB::table('user_roles')->insert([
            //         'role_id' => $roleItem,
            //         'user_id' => $account->id,
            //     ]);
            // }

            // C2 qua model khai báo relationship
            $account->roles()->attach($roleIds);
            $this->toastSuccess("Create Account Success", "Success");
            DB::commit();
            return redirect()->route('accounts.index');
        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error creating account", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        try {
            $account = $this->accountRepo->findDataById($id);
            $roles = $this->roleRepo->getAll();
            $rolesOfUser = $account->roles;
            return view('admin.accounts.update', compact('account', 'roles', 'rolesOfUser'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(AccountRequest $request, $id)
    {
        try {
            DB::BeginTransaction();
            $data = [
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'address' => $request->get('address'),
                'status' => $request->get('status'),

            ];
            $image_path = $request->hasFile('image_path');
            if ($image_path) {
                // Upload an Image File to Cloudinary with One line of Code
                $uploadedFileUrl = Cloudinary::upload($request->file('image_path')->getRealPath(), [
                    'folder' => 'Account',
                ])->getSecurePath();
                if (!empty($uploadedFileUrl)) {
                    $data['image_path'] = $uploadedFileUrl;
                }
            }
            $account = $this->accountRepo->updateDataById($id, $data);
            $account->roles()->sync($request->get('role_id'));
            $this->toastSuccess("Updated account successfully", "Success");
            DB::commit();
            return redirect()->route('accounts.index');
        } catch (Exception $e) {
            DB::rollback();
            $this->toastError("Error updating account", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function editPassword($id)
    {
        try {
            $currentId = $id;
            return view('admin.accounts.changePassword', compact('currentId'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function updatePassword($id, Request $request)
    {
        try {
            $account = $this->accountRepo->findDataById($id);
            $old_Password = $request->get('oldpassword');
            $new_Password = $request->get('newpassword');
            $confirm_Password = $request->get('confirmpassword');

            if (Hash::check($old_Password, $account->password)) {
                if ($new_Password == $confirm_Password) {
                    $hash_Passwrod = Hash::make($new_Password);
                    $this->accountRepo->changePassword($id, $hash_Passwrod);
                    $this->toastSuccess("Change password successfully", "Success");
                    return redirect()->route('accounts.index');
                } else {
                    $this->toastWarning("New password and confirm password is not the same", "Warning");
                    Session::flash('error', 'New password and confirm password is not the same.');
                    return redirect()->back();
                }

            } else {
                $this->toastWarning("Old password is not correct", "Warning");
                Session::flash('error', 'Old password is not correct.');
                return redirect()->back();
            }

        } catch (Exception $e) {
            $this->toastError("Error change password account", "Error");
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }
}
