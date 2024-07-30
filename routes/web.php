<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialiteController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes([
    'verify' => true,
    'register' => true,
]);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirectToProvider'])->name('auth.socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])->name('auth.socialite.callback');

Route::post('/auth/onetap', [LoginController::class, 'onetap'])->name('auth.onetap');
