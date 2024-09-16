<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\Register as RegisterRequest;
use App\Models\Role;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Register extends Controller
{
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
        $data['password'] = Hash::make($data['password']);
        $roleIdUser = Role::where('name', Roles::USER)->firstOrfail()->id;
        $user = User::create($data);
        $user->roles()->attach($roleIdUser);
        event(new Registered($user));
        $request->session()->regenerate();
        Auth::login($user);
        return redirect()->intended(RouteServiceProvider::HOME)->with('notification', 'auth.register');
    }
}
