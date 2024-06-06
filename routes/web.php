<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StripeConnectController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Site\CheckoutController;
use App\Http\Controllers\Site\TicketScannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\PaymentController;

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

// Front
Route::get('/', [\App\Http\Controllers\Site\EventController::class, 'index']);
Route::get('/events', [\App\Http\Controllers\Site\EventController::class, 'index'])->name('site.events');
Route::get('/events/{slug}', [\App\Http\Controllers\Site\EventController::class, 'show'])->name('site.event');Route::get('/subscriptions/{id}', 'Site\SubscriptionController@show')->name('site.subscriptions.show');
Route::get('/checkout', [CheckoutController::class, 'showStep1']);
Route::get('/checkout/step2', [CheckoutController::class, 'showStep2'])->name('checkout.step2');
Route::get('/checkout/step3', [CheckoutController::class, 'showStep3'])->name('checkout.step3');
Route::post('/bookings/events/{event}', [BookingController::class, 'bookTickets']);
Route::post('/bookings/bookSubscriptionTickets', [BookingController::class, 'bookSubscriptionTickets']);
Route::post('/bookings/start-time/{session_id}', [BookingController::class, 'getBookingStartTime']);
Route::post('/bookings/expire-session/{session_id}', [BookingController::class, 'expireBookings']);
Route::get('/subscriptions/{id}', [App\Http\Controllers\Site\SubscriptionController::class, 'show'])->name('subscriptions.show');

// Payments
Route::post('/stripe/session', [PaymentController::class, 'createCheckoutSession'])->name('stripe.session');
Route::post('/stripe/webhook', [PaymentController::class, 'handleWebhook'])->name('stripe.webhook');

// Scanner
Route::get('/scanner', [TicketScannerController::class, 'show'])->name('site.scanner');

// Admin
Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Tenants
Route::get('admin/tenants/delete/{tenantId}', [TenantController::class, 'destroy'])->name('tenants.destroy');
Route::post('admin/tenants/adminLogin', [TenantController::class, 'adminLogin'])->name('tenants.adminLogin');
Route::post('admin/tenants/superAdminLogin', [TenantController::class, 'superAdminLogin'])->name('tenants.superAdminLogin');
Route::resource('admin/tenants', TenantController::class)->except('show', 'destroy');

// Events
Route::post('admin/event/getDefaultSeatPlans', [EventController::class, 'getDefaultSeatPlans'])->name('events.getDefaultSeatPlans');
Route::post('admin/event/getData/{id}', [EventController::class, 'getData'])->name('events.getData');
Route::get('admin/events/{eventId}/status/{status}', [EventController::class, 'status'])->name('events.status');
Route::get('admin/events/delete/{eventId}', [EventController::class, 'destroy'])->name('events.destroy');
Route::resource('admin/events', EventController::class)->except('show', 'destroy');

// Orders
Route::get('admin/orders/{orderId}/invoice', [OrderController::class, 'showInvoice'])->name('showInvoice');
Route::get('admin/orders/{orderId}/tickets', [OrderController::class, 'showTickets'])->name('showTickets');
Route::resource('admin/orders', OrderController::class)->only('show');

// Users
Route::resource('admin/users', UserController::class)->except('show', 'destroy');
Route::get('admin/users/delete/{userId}', [UserController::class, 'destroy'])->name('users.destroy');

// Venues
Route::resource('admin/venues', VenueController::class)->except('show', 'destroy');
Route::get('admin/venues/delete/{venueId}', [VenueController::class, 'destroy'])->name('venues.destroy');

// Subscriptions
Route::resource('admin/subscriptions', SubscriptionController::class)->except('show', 'destroy');
Route::get('admin/subscriptions/delete/{voucherId}', [SubscriptionController::class, 'destroy'])->name('subscriptions.destroy');

// Discounts
Route::resource('admin/discounts', DiscountController::class)->except('show', 'destroy');
Route::get('admin/discounts/delete/{venueId}', [DiscountController::class, 'destroy'])->name('discounts.destroy');

// Vouchers
Route::resource('admin/vouchers', VoucherController::class)->except('show', 'destroy');
Route::get('admin/vouchers/delete/{voucherId}', [VoucherController::class, 'destroy'])->name('vouchers.destroy');

Route::get('admin/finance', [FinanceController::class, 'index'])->name('finance');

// Settings
Route::get('admin/settings', [SettingsController::class, 'index'])->name('settings');
Route::post('admin/settings/updateTenant', [SettingsController::class, 'updateTenant'])->name('settings.updateTenant');
Route::post('admin/settings/updateAccount', [SettingsController::class, 'updateAccount'])->name('settings.updateAccount');
Route::post('admin/settings/updateFinance', [SettingsController::class, 'updateFinance'])->name('settings.updateFinance');
Route::post('admin/settings/updatePassword', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
Route::post('admin/support', [SupportController::class, 'supportRequest'])->name('support');

// Media
Route::post('media/file', [MediaController::class, 'uploadFile'])->name('media.upload_file');

// Payments
Route::get('/connect-account', [StripeConnectController::class, 'connectAccount'])->name('stripe.connect.connectAccount');
Route::get('/check-connection', [StripeConnectController::class, 'checkConnection'])->name('stripe.connect.checkConnection');
