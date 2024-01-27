<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('create-data', function () {
    // $admin = User::create([
    //     'first_name' => 'Илья',
    //     'middle_name' => 'Евгеньевич',
    //     'last_name' => 'Неустроев',
    //     'email' => 'jjnn95@yandex.ru',
    //     'password' => Hash::make(123),
    // ]);
    // $admin->email_verified_at = Carbon::now();
    // $admin->save();
    // $admin->roles()->sync([1,2,3]);
    $user = User::create([
        'first_name' => 'Елена',
        'middle_name' => 'Борисовна',
        'last_name' => 'Език',
        'email_verified_at' => Carbon::now(),
        'email' => 'ezikelena13081994@yandex.ru',
        'password' => Hash::make(123321),
    ]);
    $user->roles()->sync([2,3]);
})->purpose('Display an inspiring quote');
