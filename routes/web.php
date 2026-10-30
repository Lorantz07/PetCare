<?php

use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DemoController::class, 'home'])->name('home');
Route::get('/layanan', [DemoController::class, 'servicesIndex'])->name('services.index');
Route::get('/layanan/{slug}', [DemoController::class, 'serviceShow'])->name('services.show');
Route::get('/masuk', [DemoController::class, 'loginPlaceholder'])->name('login');
Route::get('/daftar', [DemoController::class, 'registerPlaceholder'])->name('register');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DemoController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/pelanggan', [DemoController::class, 'adminCustomers'])->name('customers');
    Route::get('/karyawan', [DemoController::class, 'adminEmployees'])->name('employees');
    Route::get('/hewan', [DemoController::class, 'adminPets'])->name('pets');
    Route::get('/layanan', [DemoController::class, 'adminServices'])->name('services');
    Route::get('/booking', [DemoController::class, 'adminBookings'])->name('bookings');
    Route::get('/booking/{code}', [DemoController::class, 'adminBookingShow'])->name('bookings.show');
    Route::get('/pembayaran', [DemoController::class, 'adminPayments'])->name('payments');
    Route::get('/laporan', [DemoController::class, 'adminReports'])->name('reports');
    Route::get('/pengaturan', [DemoController::class, 'adminSettings'])->name('settings');
});

Route::prefix('karyawan')->name('staff.')->group(function () {
    Route::get('/dashboard', [DemoController::class, 'staffDashboard'])->name('dashboard');
    Route::get('/jadwal', [DemoController::class, 'staffSchedule'])->name('schedule');
    Route::get('/booking', [DemoController::class, 'staffBookings'])->name('bookings');
    Route::get('/booking/{code}', [DemoController::class, 'staffBookingShow'])->name('bookings.show');
    Route::get('/riwayat', [DemoController::class, 'staffHistory'])->name('history');
    Route::get('/profil', [DemoController::class, 'staffProfile'])->name('profile');
});

Route::prefix('pelanggan')->name('customer.')->group(function () {
    Route::get('/dashboard', [DemoController::class, 'customerDashboard'])->name('dashboard');
    Route::get('/hewan', [DemoController::class, 'customerPets'])->name('pets');
    Route::get('/layanan', [DemoController::class, 'customerServices'])->name('services');
    Route::get('/layanan/{slug}', [DemoController::class, 'customerServiceShow'])->name('services.show');
    Route::get('/booking', [DemoController::class, 'customerBooking'])->name('booking');
    Route::get('/booking/sukses', [DemoController::class, 'customerBookingSuccess'])->name('booking.success');
    Route::get('/riwayat', [DemoController::class, 'customerBookings'])->name('bookings');
    Route::get('/pembayaran', [DemoController::class, 'customerPayments'])->name('payments');
    Route::get('/ulasan', [DemoController::class, 'customerReviews'])->name('reviews');
    Route::get('/profil', [DemoController::class, 'customerProfile'])->name('profile');
});
