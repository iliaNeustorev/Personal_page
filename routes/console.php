<?php

use App\Enums\Roles;
use App\Models\Role;
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
    $user = User::create([
        'first_name' => 'Елена',
        'middle_name' => 'Борисовна',
        'last_name' => 'Език',
        'email' => 'ezikelena13081994@yandex.ru',
        'password' => Hash::make('@123321@'),
        'email_verified_at' => Carbon::now()
    ]);
    $roleIdsUser = Role::whereIn('name', [Roles::USER, Roles::ADMIN, Roles::MODERATOR])
        ->pluck('id')
        ->toArray();
    $user->roles()->sync($roleIdsUser);
})->purpose('Display an inspiring quote');

Artisan::command('create-category', function () {
})->purpose('Display an inspiring quote');
