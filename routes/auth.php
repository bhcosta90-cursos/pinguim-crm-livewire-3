<?php

declare(strict_types = 1);

use App\Actions\Auth\LogoutAction;
use App\Livewire;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', Livewire\Auth\Login::class)->name('login');
    Route::get('/register', Livewire\Auth\Register::class)->name('register');
    Route::as('password.')->prefix('password')->group(function () {
        Route::get('/recovery', Livewire\Auth\Password\Recovery::class)->name('recovery');
        Route::get('/reset', Livewire\Auth\Password\Reset::class)->name('reset');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/email-validation', Livewire\Auth\ValidationEmail::class)->name('email-validation');
    Route::post('/logout', function (LogoutAction $logout) {
        $logout->handle();

        return redirect()->route('login');
    })->name('logout');
});
