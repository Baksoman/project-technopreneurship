<?php

use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('welcome');
Route::get('/compatibility', fn() => view('compatibility'))->name('compatibility');
Route::get('/compare', fn() => view('compare'))->name('compare');

// User Auth Routes
Route::get('/auth', [UserAuthController::class, 'showAuth'])->name('auth');
Route::get('/login', [UserAuthController::class, 'showAuth'])->name('login');
Route::get('/signup', [UserAuthController::class, 'showAuth'])->name('signup');
Route::post('/login', [UserAuthController::class, 'login'])->name('login.post')->middleware('throttle:5,1');
Route::post('/register', [UserAuthController::class, 'register'])->name('register')->middleware('throttle:3,1');
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');

Route::get('/auth/google', [UserAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [UserAuthController::class, 'handleGoogleCallback'])->name('google.callback');

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth.session')->group(function () {
    Route::get('/my-builds', fn() => view('my-builds'))->name('my-builds');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});