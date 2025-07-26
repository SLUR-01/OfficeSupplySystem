<?php

use App\Models\RequestSupply;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Controller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ManageController;
use App\Http\Controllers\User\FeedbackController;
use App\Http\Controllers\User\SignatureController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\RequestSupplyController;
use App\Http\Controllers\User\Auth\PasswordResetLinkController;


Route::middleware(['auth', 'is_user:user'])->group(function ()

{
    // Profile Routes
    Route::get('/user/profile/edit', [ProfileController::class, 'editProfile'])->name('user.profile.edit');
    Route::patch('/user/profile/update', [ProfileController::class, 'updateProfile'])->name('user.profile.update');
    Route::delete('/user/profile/destroy', [ProfileController::class, 'destroyProfile'])->name('user.profile.destroy');

    // Dashboard Route
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    // Requests, Return Route

    // Request History
    Route::get('/history', [RequestSupplyController::class, 'history'])->name('user.history');

    //TRANSACTION CONTROLLER
    Route::get('/get-request-data/{id}', function($id) {
    $request = Request::find($id);
    return response()->json($request);
    })->middleware('auth');


    Route::controller(RequestSupplyController::class)->group(function() {
    // Main tabs
    Route::get('/status', 'status')->name('user.status'); // Main entry point

    // Request routes
    Route::get('/request', 'request')->name('user.request');
    Route::post('/request', 'storeRequest')->name('user.request.store');


    // Return routes
    Route::get('/return', 'return')->name('user.return');
    Route::get('/get-request-details/{id}', 'getRequestDetails');
    Route::post('/returns', 'store')->name('user.return.store');

    // History
    Route::get('/history', 'history')->name('user.history.history');
    });

    
    Route::get('/feedback', [FeedbackController::class, 'feedback'])->name('user.feedback');
     Route::get('/manage', [ManageController::class, 'manage'])->name('user.manage');

    Route::post('/feedback', [FeedbackController::class, 'store'])->name('user.feedback.store');
    Route::post('/user/signature/save', [SignatureController::class, 'saveSignature'])->name('user.signature.save');

    Route::get('/user/return/check/{requestId}', [RequestSupplyController::class, 'checkReturnStatus']);

});