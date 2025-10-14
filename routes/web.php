<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LiveSettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KeywordController;
use App\Http\Controllers\Admin\ChatManagementController;
use App\Http\Controllers\StreamController;
use App\Http\Controllers\LiveStaff\DashboardController as LiveStaffDashboardController;
use App\Http\Controllers\CSKH\DashboardController as CSKHDashboardController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('homepage');

// Authentication routes
Auth::routes();

// Redirect after login based on role
Route::get('/home', function () {
    $user = auth()->user();
    
    if ($user->hasRole('Admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('Nhân viên Live')) {
        return redirect()->route('live-staff.dashboard');
    } elseif ($user->hasRole('CSKH')) {
        return redirect()->route('cskh.dashboard');
    }
    
    return redirect('/');
})->middleware('auth')->name('home');

// Admin routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('live-settings', LiveSettingController::class);
    Route::resource('users', UserController::class);
    Route::resource('keywords', KeywordController::class);
    Route::post('keywords/{keyword}/toggle', [KeywordController::class, 'toggle'])->name('keywords.toggle');
    Route::post('keywords/test', [KeywordController::class, 'test'])->name('keywords.test');
    
    // Chat management routes
    Route::resource('chat', ChatManagementController::class)->only(['index', 'show', 'destroy']);
    Route::get('chat-stats', [ChatManagementController::class, 'stats'])->name('chat.stats');
    Route::get('chat-export', [ChatManagementController::class, 'export'])->name('chat.export');
    Route::post('chat/{message}/toggle-block', [ChatManagementController::class, 'toggleBlock'])->name('chat.toggle-block');
    
    // Stream management routes
    Route::get('stream', [StreamController::class, 'index'])->name('stream.index');
    Route::post('stream/start-file', [StreamController::class, 'startFileStream'])->name('stream.start-file');
    Route::post('stream/start-test', [StreamController::class, 'startTestStream'])->name('stream.start-test');
    Route::post('stream/stop', [StreamController::class, 'stopStream'])->name('stream.stop');
    Route::get('stream/status', [StreamController::class, 'getStreamStatus'])->name('stream.status');
    Route::get('stream/test-connection', [StreamController::class, 'testConnection'])->name('stream.test-connection');
});

// Live Staff routes
Route::middleware(['auth', 'role:Nhân viên Live'])->prefix('live-staff')->name('live-staff.')->group(function () {
    Route::get('/dashboard', [LiveStaffDashboardController::class, 'index'])->name('dashboard');
    
    // Chat management routes for Live Staff (reuse Admin ChatManagementController)
    Route::get('chat', [ChatManagementController::class, 'index'])->name('chat.index');
    Route::get('chat/{message}', [ChatManagementController::class, 'show'])->name('chat.show');
    Route::delete('chat/{message}', [ChatManagementController::class, 'destroy'])->name('chat.destroy');
    Route::get('chat-stats', [ChatManagementController::class, 'stats'])->name('chat.stats');
    Route::get('chat-export', [ChatManagementController::class, 'export'])->name('chat.export');
    Route::post('chat/{message}/toggle-block', [ChatManagementController::class, 'toggleBlock'])->name('chat.toggle-block');
});

// CSKH routes
Route::middleware(['auth', 'role:CSKH'])->prefix('cskh')->name('cskh.')->group(function () {
    Route::get('/dashboard', [CSKHDashboardController::class, 'index'])->name('dashboard');
    Route::resource('keywords', KeywordController::class)->only(['index', 'store', 'update', 'destroy']);
    Route::post('keywords/{keyword}/toggle', [KeywordController::class, 'toggle'])->name('keywords.toggle');
    Route::post('keywords/test', [KeywordController::class, 'test'])->name('keywords.test');
});

// Auth status check route
Route::get('/api/auth-status', function (Request $request) {
    return response()->json([
        'authenticated' => Auth::check(),
        'user_id' => Auth::id(),
        'session_id' => session()->getId(),
        'session_data' => session()->all()
    ]);
});
