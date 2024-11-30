<?php

declare(strict_types = 1);

use App\Livewire;
use Illuminate\Support\Facades\Route;

include __DIR__ . '/auth.php';

Route::get('/', Livewire\Welcome::class);
Route::middleware(['auth', 'verify'])->group(function () {
    Route::get('/dashboard', Livewire\Welcome::class)->name('dashboard');
});
