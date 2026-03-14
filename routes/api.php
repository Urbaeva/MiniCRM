<?php

use App\Http\Controllers\Api\TicketController;
use Illuminate\Support\Facades\Route;

Route::post('/tickets', [TicketController::class, 'store'])->name('api.tickets.store');
Route::get('/tickets/statistics', [TicketController::class, 'statistics'])->name('api.tickets.statistics');