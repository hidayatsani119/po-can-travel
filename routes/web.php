<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\TripController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    return redirect()->route('login');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // User routes
    Route::prefix('user')->name('user.')->group(function () {
        // Dashboard
        Route::get('/dashboard', function () {
            return view('user.dashboard');
        })->name('dashboard');

        // Trips
        Route::get('/trips', [TripController::class, 'index'])->name('trips.index');
        Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');

        // Bookings
        Route::resource('bookings', BookingController::class)->except(['create', 'edit']);

        // ✅ TAMBAHKAN INI: Route untuk download ticket
        Route::get('/bookings/{booking}/ticket', [BookingController::class, 'downloadTicket'])
            ->name('bookings.download-ticket');

        // Payments
        Route::get('/payments/create/{booking}', [PaymentController::class, 'create'])
            ->name('payments.create');
        Route::post('/payments/{booking}', [PaymentController::class, 'store'])
            ->name('payments.store');
        Route::get('/payments/{payment}/edit', [PaymentController::class, 'edit'])
            ->name('payments.edit');
        Route::put('/payments/{payment}', [PaymentController::class, 'update'])
            ->name('payments.update');
    });

    // Admin routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Bookings
        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::put('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])
            ->name('bookings.update-status');
        Route::put('/payments/{payment}/status', [AdminBookingController::class, 'updatePaymentStatus'])
            ->name('bookings.update-payment-status');
    });
});

require __DIR__.'/auth.php';
