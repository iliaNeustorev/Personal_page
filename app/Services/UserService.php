<?php

namespace App\Services;

use App\Enums\Roles;
use App\Jobs\SendRegisterMail;
use App\Mail\NewFeedback;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserService
{
    const MODER_EMAIL_SEND = 'jjnn95@yandex.ru';
    /**
     *
     * @param array $data
     * @return User
     */
    public function registerUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        $roleIdUser = Role::where('name', Roles::USER)->firstOrfail()->id;
        $user = User::create($data);
        $user->roles()->attach($roleIdUser);
        SendRegisterMail::dispatch($user);
        return $user;
    }

    /**
     *
     * @param User $user
     * @param array $data
     * @return void
     */
    public function createFeedback(User $user, array $data): void
    {
        $feedback = $user->feedbacks()->create($data);
        $moder = User::where('email', self::MODER_EMAIL_SEND)->firstOrfail();
        Mail::to($moder)->send(new NewFeedback($feedback));
    }
}
