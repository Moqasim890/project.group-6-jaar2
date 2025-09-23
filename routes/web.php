<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\StandController;

// onderhoud pagina
Route::view('/onderhoud', 'onderhoud')->name('onderhoud');

// normale routes
Route::get('/', fn() => view('welcome'))->name('home');
Route::resource('evenements', EvenementController::class);
Route::resource('stands', StandController::class);

// fallback: ALLES wat niet bestaat -> onderhoud
Route::fallback(function () {
    return redirect()->route('onderhoud');
});

<<<<<<< HEAD

=======
Route::get('/tickets', [App\Http\Controllers\TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/{evenement}', [App\Http\Controllers\TicketController::class, 'show'])->name('tickets.show');
>>>>>>> 3a465e1e2ff37ef92f393aa14bb154825221052b
