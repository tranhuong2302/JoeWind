<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Interfaces\Auth\IAuthRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private IAuthRepository $authRepo;

    public function __construct(IAuthRepository $authRepository)
    {
        $this->authRepo = $authRepository;
    }

    public function login()
    {
        return view('auth.login.auth-login');
    }

    public function register()
    {
        return view('auth.login.auth-register');
    }

    public function forgotPassword()
    {
        return view('auth.login.auth-forgot-password');
    }

    public function unauthorized()
    {
        return view('errors.403');
    }

    public function postRegister(RegisterRequest $registerRequest)
    {
        try {
            $data = [
                'name' => $registerRequest->input('username'),
                'email' => $registerRequest->input('email'),
                'password' => Hash::make($registerRequest->get('password')),
                'status' => 1,
            ];
            $checkExistsByEmail = $this->authRepo->checkExistsByEmail($registerRequest->input('email'));
            if ($checkExistsByEmail != null) {
                Session::flash('error', "Email is exists");
                return redirect()->back();
            } else $this->authRepo->register($data);
            return view('auth.login.auth-login');
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function postLogin(LoginRequest $loginRequest)
    {
        try {
            $credentials = [
                'email' => $loginRequest->input('email'),
                'password' => $loginRequest->input('password'),
            ];
            $remember = $loginRequest->has('remember-me');
            $user = $this->authRepo->login($credentials, $remember);
            if ($user) {
                if (auth()->user()->status == 0) {
                    $this->authRepo->logout();
                    Session::flash('error', "Your account is blocked");
                    return redirect()->route('auth.login');
                }
                return redirect()->route('admin.dashboard');
            } else {
                Session::flash('error', "Wrong email or password. Please try again!");
                return redirect()->route('auth.login');
            }
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function logout()
    {
        $this->authRepo->logout();
        return redirect()->route('auth.login');
    }
}
