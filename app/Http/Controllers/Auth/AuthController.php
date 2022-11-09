<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Eloquent\AuthRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private $authRepo;

    public function __construct(AuthRepository $authRepository)
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
    public function unauthorized(){
        return view('errors.403Page');
    }

    public function postRegister(RegisterRequest $registerRequest)
    {
        try {
            $data = [
                'name' => $registerRequest->username,
                'email' => $registerRequest->email,
                'password' => Hash::make($registerRequest->password),
                'status' => 1,
            ];
            $this->authRepo->register($data);
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
                'email' => $loginRequest->email,
                'password' => $loginRequest->password,
            ];
            $remember = $loginRequest->has('remember-me');
            $user = $this->authRepo->login($credentials, $remember);
            if ($user) return redirect()->route('admin.dashboard');
            else return redirect()->back();
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('auth.login');
    }
}
