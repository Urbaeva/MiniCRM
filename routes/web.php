<?php

use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

// Widget
Route::get('/widget', fn () => view('widget'))->name('widget');

// Auth
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin (manager only)
Route::prefix('admin')
	->middleware(['auth', 'role:manager'])
	->name('admin.')
	->group(function () {
		Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
		Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
		Route::patch('/tickets/{id}/status', [TicketController::class, 'updateStatus'])->name('tickets.update-status');
	});
