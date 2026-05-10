<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
Route::get('/', function () {
    return redirect()->route('login');
});

// --- Authenticated Routes ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard — all roles
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // --- Employee & Agent Routes ---
    Route::middleware(['role:employee,agent,admin'])->prefix('tickets')->name('tickets.')->group(function () {
        // Ticket routes will be added in Phase 3
    });

    // --- Agent & Admin Routes ---
    Route::middleware(['role:agent,admin'])->prefix('agent')->name('agent.')->group(function () {
        // Agent routes will be added in Phase 3
    });

    // --- Admin Only Routes ---
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Admin routes will be added in Phase 3
    });

});

require __DIR__.'/auth.php';