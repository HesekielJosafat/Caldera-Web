<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\OtpController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ── Public Routes (tidak perlu token) ────────────────────────────────────────
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::get('/menus',          [App\Http\Controllers\Api\MenuController::class,        'index']);
Route::get('/menus/{id}',     [App\Http\Controllers\Api\MenuController::class,        'show']);
Route::get('/promos',         [App\Http\Controllers\Api\PromoController::class,       'index']);
Route::get('/gallery',        [App\Http\Controllers\Api\GalleryController::class,     'index']);
Route::get('/testimonials',   [App\Http\Controllers\Api\TestimonialController::class, 'index']);
    
// ── Protected Routes (perlu JWT token) ───────────────────────────────────────
Route::middleware('jwt.auth')->group(function () {

    // Auth
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/me',       [AuthController::class, 'me']);

    // OTP
    Route::post('/otp/send',   [OtpController::class, 'send']);
    Route::post('/otp/verify', [OtpController::class, 'verify']);

    // Notifikasi
    Route::get('/notifications/latest', [\App\Http\Controllers\NotificationController::class, 'getLatest']);
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'getAll']);
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead']);


    // Profile
    Route::get('/profile', [App\Http\Controllers\Api\ProfileController::class, 'show']);
    Route::put('/profile', [App\Http\Controllers\Api\ProfileController::class, 'update']);

    // Testimonial (buat ulasan — perlu login)
    Route::post('/testimonials', [App\Http\Controllers\Api\TestimonialController::class, 'store']);

    // ── Perlu JWT + OTP verified ──────────────────────────────────────────────
    Route::middleware('otp.verified')->group(function () {

        // Reservasi meja
        Route::get('/reservations',          [App\Http\Controllers\Api\ReservationController::class, 'index']);
        Route::post('/reservations',         [App\Http\Controllers\Api\ReservationController::class, 'store']);
        Route::get('/reservations/{id}',     [App\Http\Controllers\Api\ReservationController::class, 'show']);
        Route::post('/reservations/{id}/cancel', [App\Http\Controllers\Api\ReservationController::class, 'cancel']);
        Route::post('/reservations/{bookingCode}/payment', [App\Http\Controllers\Reservation\PaymentController::class, 'uploadTablePayment']);

        // Tiket kolam
        Route::get('/tickets',       [App\Http\Controllers\Api\TicketController::class, 'index']);
        Route::post('/tickets',      [App\Http\Controllers\Api\TicketController::class, 'store']);
        Route::get('/tickets/{id}',  [App\Http\Controllers\Api\TicketController::class, 'show']);
        Route::post('/tickets/{ticketCode}/payment',        [App\Http\Controllers\Api\TicketController::class, 'uploadPayment']);
    });
});