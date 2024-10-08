<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginFormAction(): View
    {
        return view('auth.login');
    }

    public function showRegisterFormAction(): View
    {
        return view('auth.register');
    }

    public function loginAction(Request $request): RedirectResponse
    {
        $user = $this->authService->login($request);

        if ($user) {
            Auth::login($user);
            return redirect(route('special.page', ['token' => $user->userToken->token]));
        }

        return redirect()->back()->with('error', 'Invalid username or phone_number');
    }

    public function logoutAction() :RedirectResponse
    {
        Auth::logout();
        return redirect()->route('indexAction')->with('success', 'You are logged out');
    }

    public function registrationAction(Request $request): RedirectResponse
    {
        $result = $this->authService->register($request);

        if ($result['status'] && $result['data']['user']) {
            Auth::login($result['data']['user']);
            return redirect()->route('special.page', ['token' => $result['data']['token']])
                ->with('success', 'Welcome to system! Your token is : ' . $result['data']['token']);
        }

        #TODO need logging
        return redirect()->back()->with('error', $result['message']);
    }
}
