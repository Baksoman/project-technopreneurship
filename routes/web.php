<?php

use Illuminate\Support\Facades\Route;

// Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

// Route::view('profile', 'profile')
//     ->middleware(['auth'])
//     ->name('profile');

// require __DIR__ . '/auth.php';

Route::get('/', fn() => view('welcome'));
Route::get('/compatibility', fn() => view('compatibility'));
Route::get('/compare', fn() => view('compare'));