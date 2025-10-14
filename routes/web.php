<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\VerkoperController;

// onderhoud pagina
Route::view('/onderhoud', 'onderhoud')->name('onderhoud');

// normale routes
Route::get('/', fn() => view('welcome'))->name('home');
Route::resource('evenements', EvenementController::class);
Route::resource('stands', StandController::class);
// Route::resource('Tickets', TicketController::class);
Route::get('Tickets', [TicketController::class, 'index'])->name('Tickets.index');
Route::get('Tickets/{evenement}', [TicketController::class, 'show'])->name('Tickets.show');
Route::resource('verkoper', VerkoperController::class);
Route::get('evenements/{evenement}', [EvenementController::class, 'show'])->name('evenements.show');



// fallback: ALLES wat niet bestaat -> onderhoud
Route::fallback(function () {
    return redirect()->route('onderhoud');
});


