<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollRunController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::get('/verify-payslip/{token}', [PayslipController::class, 'verify'])->name('payslips.verify');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::middleware('permission:manage company settings')->group(function () {
        Route::get('/settings/company', [CompanySettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings/company', [CompanySettingController::class, 'update'])->name('settings.update');
    });

    Route::resource('employees', EmployeeController::class)->middleware('permission:manage employees');
    Route::resource('payroll-runs', PayrollRunController::class)->except(['edit', 'update'])->middleware('permission:manage payroll');

    Route::get('/my-payslips', [PayslipController::class, 'mine'])->middleware('permission:view own payslips')->name('my-payslips.index');
    Route::get('/my-payslips/{payslip}', [PayslipController::class, 'mineShow'])->middleware('permission:view own payslips')->name('my-payslips.show');
    Route::get('/my-payslips/{payslip}/download', [PayslipController::class, 'mineDownload'])->middleware('permission:view own payslips')->name('my-payslips.download');

    Route::get('/payslips/{payslip}', [PayslipController::class, 'show'])->middleware('permission:manage payroll')->name('payslips.show');
    Route::get('/payslips/{payslip}/download', [PayslipController::class, 'download'])->middleware('permission:manage payroll')->name('payslips.download');
    Route::patch('/payslips/{payslip}/payment-status', [PayslipController::class, 'updatePaymentStatus'])->middleware('permission:manage payroll')->name('payslips.payment-status.update');

    Route::resource('users', UserController::class)->except('show')->middleware('permission:manage users');
    Route::resource('roles', RoleController::class)->except('show')->middleware('permission:manage roles');
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->middleware('permission:view audit logs')->name('audit-logs.index');
});
