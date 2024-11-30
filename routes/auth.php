<?php

declare(strict_types = 1);

use App\Livewire;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', Livewire\Auth\Register::class)->name('register');
    Route::get('/login', Livewire\Auth\Register::class)->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/email-validation', Livewire\Auth\ValidationEmail::class)->name('email-validation');
});
