<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountRequest;
use App\Repositories\Eloquent\AccountRepository;
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

    public function __construct(AccountRepository $accountRepo)
    {
        $this->accountRepo = $accountRepo;
    }

    public function index()
    {
        try {
            $accounts = $this->accountRepo->getAccounts();
            return view('admin.accounts.index', compact('accounts'));
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }

    }

    public function create()
    {
        try {
            return view('admin.accounts.add');
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
            $account = $this->accountRepo->createAccount($data);
            if ($account) {
                $this->toastSuccess("Create Account Success", "Success");
                DB::commit();
                return view('admin.accounts.add');
            } else  return redirect()->back();
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
            $account = $this->accountRepo->getAccountById($id);
            return view('admin.accounts.update', compact('account'));
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
            $account = $this->accountRepo->updateAccountById($id, $data);
            if ($account) {
                $this->toastSuccess("Updated account successfully", "Success");
                DB::commit();
                return redirect()->route('accounts.index');
            } else  return redirect()->back();

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
            $account = $this->accountRepo->getAccountById($id);
            $old_Password = $request->get('oldpassword');
            $new_Password = $request->get('newpassword');
            $confirm_Password = $request->get('confirmpassword');

            if (Hash::check($old_Password, $account->password)) {
                if ($new_Password == $confirm_Password) {
                    $hash_Passwrod = Hash::make($new_Password);
                    $this->accountRepo->changePassword($id, $hash_Passwrod);
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
