<?php

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Chairman\DashboardController;
    use App\Http\Controllers\ProfileController;


Route::middleware(['auth', 'is_chairman:chairman'])->group(function (){

    Route::get('chairman/dashboard', [DashboardController::class, 'dashboard'])->name('chairman.dashboard');

    Route::get('/chairman/profile/edit', [ProfileController::class, 'editProfile'])->name('chairman.profile.edit');
    Route::patch('/chairman/profile/update', [ProfileController::class, 'updateProfile'])->name('chairman.profile.update');
    Route::delete('/chairman/profile/destroy', [ProfileController::class, 'destroyProfile'])->name('chairman.profile.destroy');

  
    Route::post('/chairman/requests/{id}/approve', [DashboardController::class, 'approve'])->name('chairman.requests.approve');

});

?>