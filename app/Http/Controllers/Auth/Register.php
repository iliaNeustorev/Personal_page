<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\Register as RegisterRequest;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Register extends Controller
{
    /**
     *
     * @param UserService $userService
     */
    public function __construct(
        public UserService $userService
    ) {}
    /**
     *
     * @return View
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     *
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $this->userService->registerUser($data);
        $request->session()->regenerate();
        Auth::login($user);
        return redirect()->intended(RouteServiceProvider::HOME)->with('notification', 'auth.register');
    }
}
