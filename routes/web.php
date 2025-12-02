<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/booking/{lapangan}', [BookingController::class, 'create'])->name('booking.form');
Route::post('/booking/{lapangan}', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booked-ranges/{date}/{lapangan?}', [BookingController::class, 'getBookedRanges'])->name('booking.ranges') 
    ->name('booking.ranges');
Route::get('/bookings', [BookingController::class, 'index'])->name('booking.index');
Route::get('/payment', function(){
    return view('payment');
});

Route::get('/bookings/{lapangan}/edit', [BookingController::class, 'edit'])->name('booking.edit');
Route::post('/bookings/{lapangan}/update', [BookingController::class, 'update'])->name('booking.update');
Route::delete('/bookings/{lapangan}', [BookingController::class, 'destroy'])->name('booking.delete');