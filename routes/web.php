<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;


use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\RequestSupplyController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::middleware('guest')->group(function () {
   
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});



Route::get('/', function () {
    return view('auth.login');
});

  
require __DIR__.'/auth.php';
require __DIR__.'/admin-route.php';
require __DIR__.'/chairman-route.php';
require __DIR__.'/dean-route.php';
require __DIR__.'/user-route.php';
