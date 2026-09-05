<?php

use Illuminate\Support\Facades\Route;

// Route::inertia('/', 'welcome')->name('home');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::inertia('dashboard', 'dashboard')->name('dashboard');
// });

// require __DIR__.'/settings.php';

Route::get('/', fn () => redirect()->route('filament.admin.auth.login'))->name('home');
