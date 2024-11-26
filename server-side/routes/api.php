<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\LokasiEventController;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('checkRole:Admin')->group(function () {
        Route::get('admin/dashboard', [DashboardController::class, 'index']);

        Route::get('admin/lokasi-event', [LokasiEventController::class, 'index']);
        Route::post('admin/lokasi-event', [LokasiEventController::class, 'store']);
        Route::post('admin/lokasi-event/{id}', [LokasiEventController::class, 'update']);
        Route::delete('admin/lokasi-event/{id}', [LokasiEventController::class, 'destroy']);

        Route::get('admin/event', [EventController::class, 'showRegistFeedback']);
        Route::post('admin/event', [EventController::class, 'store']);
        Route::post('admin/event/{id}', [EventController::class, 'update']);
        Route::delete('admin/event/{id}', [EventController::class, 'destroy']);
        
        Route::post('admin/pendaftaran', [PendaftaranController::class, 'updateStatus']);

        Route::post('admin/feedback', [FeedBackController::class, 'deleteFeedBack']);
    });
    
    Route::middleware('checkRole:User')->group(function () {
        Route::get('user/pendaftaran/{id_user}', [PendaftaranController::class, 'getPendaftaranByUserid']);
        Route::get('user/pendaftaran/{id_event}', [FeedBackController::class, 'getFeedbackByEventid']);
        Route::post('user/pendaftaran', [PendaftaranController::class, 'daftarEvent']);

        Route::post('user/feedback', [FeedBackController::class, 'createFeedBack']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('event', [EventController::class, 'index']);
