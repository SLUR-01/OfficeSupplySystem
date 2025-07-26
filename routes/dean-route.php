<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dean\DashboardController;

use App\Http\Controllers\ProfileController;


Route::middleware(['auth', 'is_dean:dean'])->group(function () {
    


Route::get('dean/dashboard', [DashboardController::class, 'dashboard'])->name('dean.dashboard');


Route::get('/dean/profile/edit', [ProfileController::class, 'editProfile'])->name('dean.profile.edit');
Route::patch('/dean/profile/update', [ProfileController::class, 'updateProfile'])->name('dean.profile.update');
Route::delete('/dean/profile/destroy', [ProfileController::class, 'destroyProfile'])->name('dean.profile.destroy');

Route::post('/approve-request/{id}', [DashboardController::class, 'approve'])->name('dean.requests.approve');

});