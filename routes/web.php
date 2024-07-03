<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/', function () {
    if(Auth::check() && !Auth::user()->active){
        return redirect('/login');
    }
    else {
        return redirect('/dashboard');
    }
});

Route::get('users/{id}', function (string $id) {
    return view('user', ['user' => User::where('id', '=', $id)->first()]);
})
    ->middleware(['auth', 'verified'])
    ->name('user');

Route::view('create-user', 'create-user')
    ->middleware(['auth', 'verified'])
    ->name('users');

Route::view('users', 'users')
    ->middleware(['auth', 'verified'])
    ->name('users');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
