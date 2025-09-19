<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tickets', [App\Http\Controllers\TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/{evenement}', [App\Http\Controllers\TicketController::class, 'show'])->name('tickets.show');
