<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Routes untuk booking
Route::get('/booking', [BookingController::class, 'create'])->name('booking.form');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booked-ranges/{date}', [BookingController::class, 'getBookedRanges'])->name('booking.ranges');
Route::get('/bookings', [BookingController::class, 'index'])->name('booking.index');