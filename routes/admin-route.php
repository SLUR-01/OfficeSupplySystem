<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\MonthlyReportController;
use App\Http\Controllers\Admin\RequestSupplyController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;


// Admin Dashboard
Route::middleware(['auth', 'is_admin:admin'])->group(function () 
{

    Route::get('/admin/profile/edit', [ProfileController::class, 'editProfile'])->name('admin.profile.edit');
    Route::patch('/admin/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
    Route::delete('/admin/profile/destroy', [ProfileController::class, 'destroyProfile'])->name('admin.profile.destroy');

    // Admin CRUD
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard'); // Display all requests
    Route::get('/admin/requests', [AdminController::class, 'requests'])->name('admin.requests'); // Display all requests
    Route::get('/admin/requests/create', [AdminController::class, 'create'])->name('admin.requests.create'); // Show create form
    Route::post('/admin/requests', [AdminController::class, 'store'])->name('admin.requests.store'); // Store a request
    Route::get('/admin/requests/{id}/edit', [AdminController::class, 'edit'])->name('admin.requests.edit'); // Show edit form
    Route::put('/admin/requests/{id}', [AdminController::class, 'update'])->name('admin.requests.update'); // Update a request
    Route::delete('/admin/requests/{id}', [AdminController::class, 'destroy'])->name('admin.requests.destroy'); // Delete a request


    // Update Request
    Route::put('admin/requests/{id}', [AdminController::class, 'update'])->name('admin.requests.update');
    Route::post('/admin/requests/{id}/approve', [RequestSupplyController::class, 'approve'])->name('admin.requests.approve');

    // Admin Manage Supplies
    Route::get('/admin/stocks', [StockController::class, 'stocks'])->name('admin.stocks');
    Route::post('/admin/update-stock', [StockController::class, 'updateStock'])->name('admin.update.stock');
    Route::post('/admin/add-new-item', [StockController::class, 'addNewItem'])->name('admin.add.newItem');  
      // Reports
    Route::get('admin/monthly-reports', [MonthlyReportController::class, 'monthlyReports'])->name('admin.monthly-reports');
    Route::get('admin/withdrawal', [TransactionController::class, 'withdrawal'])->name('admin.withdrawal');
    Route::post('/admin/requests/{id}/update-withdrawal', [TransactionController::class, 'updateWithdrawal'])->name('admin.requests.update-withdrawal');


    Route::post('/admin/requests/{id}/withdrawn-by', [TransactionController::class, 'withdrawnBy']);

    Route::get('/admin/return', [TransactionController::class, 'return'])->name('admin.return');
    Route::post('/admin/returns/{id}/approve', [TransactionController::class, 'approve'])->name('admin.return.approve');
    Route::post('/admin/returns/{id}/reject', [TransactionController::class, 'reject'])->name('admin.return.reject');
    Route::post('/update-return', [TransactionController::class, 'updateReturn'])->name('update.return');
    Route::post('/admin/return/completed', [TransactionController::class, 'completedReturn'])->name('admin.completedReturn.update');

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'create'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    Route::get('/admin/feedback', [FeedbackController:: class, 'feedback'])->name('admin.feedback');

    Route::get('/api/withdrawals/monthly-completed', [MonthlyReportController::class, 'getMonthlyCompletedWithdrawals']);
    Route::get('/api/returns/monthly', [MonthlyReportController::class, 'getMonthlyReturns']);
   
});