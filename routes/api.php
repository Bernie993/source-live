<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LiveStreamController;

// User eligibility check
Route::post('/check-user-eligibility', [HomeController::class, 'checkUserEligibility'])->middleware('web');

// External user authentication
Route::post('/external-login', [AuthController::class, 'externalLogin']);
Route::post('/user-profile', [AuthController::class, 'profile']);

// Chat API routes - SỬA: sử dụng middleware disable CSRF
Route::prefix('chat')->middleware(['web', 'disable.csrf.api'])->group(function () {
    Route::post('/send', [ChatController::class, 'sendMessage']);
    Route::get('/messages', [ChatController::class, 'getMessages']);
    Route::get('/online-count', [ChatController::class, 'getOnlineCount']);
});

// Live Stream API routes
Route::prefix('live')->group(function () {
    Route::get('/status', [LiveStreamController::class, 'getStreamStatus']);
    Route::get('/viewer-count', [LiveStreamController::class, 'updateViewerCount']);
    Route::get('/all-streams', [LiveStreamController::class, 'getAllLiveStreams']);
});

// User info route
Route::get('/user', function (Request $request) {
    if (Auth::check()) {
        return response()->json([
            'authenticated' => true,
            'user' => Auth::user(),
            'session_id' => session()->getId()
        ]);
    }
    return response()->json([
        'authenticated' => false,
        'error' => 'Unauthenticated',
        'session_id' => session()->getId()
    ], 401);
})->middleware('web');

// Auth status check route
Route::get('/auth-status', function (Request $request) {
    return response()->json([
        'authenticated' => Auth::check(),
        'user_id' => Auth::id(),
        'session_id' => session()->getId(),
        'session_data' => session()->all()
    ]);
})->middleware('web');
