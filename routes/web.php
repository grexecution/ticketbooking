<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SupportController;
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

//Route::get('/', function () {
//    if (!auth()->check()) {
//        return redirect()->route('login');
//    }
//    return redirect('/dashboard');
//});
Route::get('/', [\App\Http\Controllers\Site\EventController::class, 'index']);
Route::get('/events', [\App\Http\Controllers\Site\EventController::class, 'index'])->name('site.events');
Route::get('/events/{eventId}', [\App\Http\Controllers\Site\EventController::class, 'show'])->name('site.event');

Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('home');
Route::get('admin/events', [EventController::class, 'index'])->name('events');
Route::get('admin/finance', [FinanceController::class, 'index'])->name('finance');
Route::get('admin/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('admin/settings/updateAccount', [SettingsController::class, 'updateAccount'])->name('settings.updateAccount');
Route::post('admin/settings/updatePassword', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
Route::post('admin/support', [SupportController::class, 'supportRequest'])->name('support');
