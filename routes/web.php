<?php

use App\Http\Controllers\DashboardControllers;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');

Route::redirect('/', '/dashboard');

Route::get('dashboard', [DashboardControllers::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
