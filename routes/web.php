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
Route::resource('verkoper', VerkoperController::class);

Route::get('/tickets', [TicketController::class, 'index'])->name('Tickets.index');
Route::get('/tickets/{id}/show', [TicketController::class, 'show'])->name('Tickets.show');
Route::get('/tickets/{id}/create', [TicketController::class, 'create'])->name('Tickets.create');
Route::get('/tickets/{id}/store', [TicketController::class, 'store'])->name('Tickets.store');
Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('Tickets.edit');
Route::Post('/tickets/{id}/update', [TicketController::class, 'update'])->name('Tickets.update');
Route::get('/tickets/{id}/destroy', [TicketController::class, 'destroy'])->name('Tickets.destroy');
Route::get('/tickets/{id}/kopen', [TicketController::class, 'showkopen'])->name('Tickets.showkopen');
Route::post('tickets/', [TicketController::class, 'kopen'])->name('Tickets.kopen');
// fallback: ALLES wat niet bestaat -> onderhoud
// Route::fallback(function () {
//     return redirect()->route('onderhoud');
// });


