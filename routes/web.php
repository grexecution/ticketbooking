<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Auth\TwoFactorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::get('/2fa', [TwoFactorController::class, 'show'])->name('2fa');
Route::get('/2fa/resendCode', [TwoFactorController::class, 'resendCode'])->name('2fa.resendCode');
Route::post('/2fa', [TwoFactorController::class, 'verify'])->name('2fa.verify');

Route::get('/', [\App\Http\Controllers\Site\EventController::class, 'index']);
Route::get('/events', [\App\Http\Controllers\Site\EventController::class, 'index'])->name('site.events');
Route::get('/events/{eventId}', [\App\Http\Controllers\Site\EventController::class, 'show'])->name('site.event');

// Admin
Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('admin/tenants/delete/{tenantId}', [TenantController::class, 'destroy'])->name('tenants.destroy');
Route::post('admin/tenants/adminLogin', [TenantController::class, 'adminLogin'])->name('tenants.adminLogin');
Route::post('admin/tenants/superAdminLogin', [TenantController::class, 'superAdminLogin'])->name('tenants.superAdminLogin');
Route::resource('admin/tenants', TenantController::class)->except('show', 'destroy');

Route::resource('admin/events', EventController::class)->except('show', 'destroy');

// Users
Route::resource('admin/users', UserController::class)->except('show', 'destroy');
Route::get('admin/users/delete/{userId}', [UserController::class, 'destroy'])->name('users.destroy');

//Venues
Route::resource('admin/venues', VenueController::class);
Route::get('admin/venues/delete/{venueId}', [VenueController::class, 'destroy'])->name('venues.destroy');

Route::resource('admin/subscriptions', SubscriptionController::class);
Route::resource('admin/discounts', DiscountController::class);
Route::resource('admin/vouchers', VoucherController::class);

Route::get('admin/finance', [FinanceController::class, 'index'])->name('finance');
Route::get('admin/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('admin/settings/updateTenant', [SettingsController::class, 'updateTenant'])->name('settings.updateTenant');
Route::post('admin/settings/updateAccount', [SettingsController::class, 'updateAccount'])->name('settings.updateAccount');
Route::post('admin/settings/updateFinance', [SettingsController::class, 'updateFinance'])->name('settings.updateFinance');
Route::post('admin/settings/updatePassword', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
Route::post('admin/support', [SupportController::class, 'supportRequest'])->name('support');

// Media
Route::post('media/file', [MediaController::class, 'uploadFile'])->name('media.upload_file');
