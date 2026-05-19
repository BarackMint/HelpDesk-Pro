<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketReplyController;
use Illuminate\Support\Facades\Route;

// --- Public Routes ---
Route::get('/', function () {
    return redirect()->route('login');
});

// --- Profile Routes (Breeze) ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Authenticated Routes ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard — all roles
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // --- Ticket Routes — all roles ---
    Route::middleware(['role:employee,agent,admin'])
        ->prefix('tickets')
        ->name('tickets.')
        ->group(function () {
            Route::get('/', [TicketController::class, 'index'])->name('index');
            Route::get('/create', [TicketController::class, 'create'])->name('create');
            Route::post('/', [TicketController::class, 'store'])->name('store');
            Route::get('/{ticket}', [TicketController::class, 'show'])->name('show');
            Route::get('/{ticket}/edit', [TicketController::class, 'edit'])->name('edit');
            Route::patch('/{ticket}', [TicketController::class, 'update'])->name('update');

            // Replies
            Route::post('/{ticket}/replies', [TicketReplyController::class, 'store'])
                ->name('replies.store');
        });

    // --- Agent & Admin Routes ---
    Route::middleware(['role:agent,admin'])
        ->prefix('agent')
        ->name('agent.')
        ->group(function () {
            // Agent specific routes added in future phases
        });

    // --- Admin Only Routes ---
    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            // Admin specific routes added in future phases
        });

});

require __DIR__.'/auth.php';