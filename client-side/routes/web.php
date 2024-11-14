<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\LokasiEventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\LandingPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::post('/daftar-event', [LandingPageController::class, 'daftarEvent'])->name('daftar-event');

Route::middleware(['isAuth'])->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'postLogin'])->name('login-post');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'postRegister'])->name('register-post');
});

Route::middleware(['isUser'])->group(function () {
    Route::get('/my-event', [LandingPageController::class, 'myEvent'])->name('my-event');
    Route::post('/create-feedback', [LandingPageController::class, 'createFeedback'])->name('create-feedback');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['isAdmin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('lokasi-event', [LokasiEventController::class, 'index'])->name('lokasi-event');
    Route::post('lokasi-event', [LokasiEventController::class, 'store'])->name('lokasi-event-post');
    Route::post('lokasi-event/{id_lokasi}', [LokasiEventController::class, 'update'])->name('lokasi-event-update');
    Route::delete('lokasi-event/{id_lokasi}', [LokasiEventController::class, 'destroy'])->name('lokasi-event-delete');
    
    Route::get('event', [EventController::class, 'index'])->name('event');
    Route::post('event', [EventController::class, 'store'])->name('event-post');
    Route::post('event/{id_event}', [EventController::class, 'update'])->name('event-update');
    Route::delete('event/{id_event}', [EventController::class, 'destroy'])->name('event-delete');

    Route::post('set-kehadiran', [EventController::class, 'setKehadiran'])->name('set-kehadiran');
    Route::post('delete-feedback', [EventController::class, 'deleteFeedback'])->name('delete-feedback');

    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
