<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AuthController as ApiAuthController;

class AuthController extends Controller
{
    protected $apiAuthController;

    public function __construct(ApiAuthController $apiAuthController)
    {
        $this->apiAuthController = $apiAuthController;
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $apiResponse = $this->apiAuthController->login($request);
        $responseData = json_decode($apiResponse->getContent(), true);

        if ($apiResponse->getStatusCode() === 200) {
            Auth::loginUsingId($responseData['data']['user']['id']);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => $responseData['message'],
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $apiResponse = $this->apiAuthController->register($request);
        $responseData = json_decode($apiResponse->getContent(), true);

        if ($apiResponse->getStatusCode() === 201) {
            Auth::loginUsingId($responseData['data']['user']['id']);
            $request->session()->regenerate();
            return redirect('/dashboard');
        }

        return back()
            ->withErrors($responseData['errors'] ?? ['error' => $responseData['message']])
            ->withInput($request->except('password', 'password_confirmation'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
