<?php

declare(strict_types = 1);

use App\Livewire;
use Illuminate\Support\Facades\Route;

include __DIR__ . '/auth.php';

Route::get('/', Livewire\Welcome::class);
Route::middleware(['auth'])->group(function () {
    Route::view('/profile', 'admin.profile.index')->name('profile');
    Route::middleware('verify')->group(function () {
        Route::get('/dashboard', Livewire\Admin\Dashboard::class)->name('dashboard');
        Route::as('admin.')->prefix('admin')->group(function () {
            Route::get('/user', Livewire\Admin\User\UserIndex::class)->name('user.index'); // TODO: Add policy to user
            Route::get('/customer', Livewire\Admin\Customer\CustomerIndex::class)
                ->middleware('can:viewAny,App\Models\Customer')
                ->name('customer.index');
        });
    });
});
