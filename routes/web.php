<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\StandController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\VerkoperController;
use App\Http\Controllers\AdminController;

// onderhoud pagina
Route::view('/onderhoud', 'onderhoud')->name('onderhoud');

// normale routes
Route::get('/', fn() => view('welcome'))->name('home');
Route::resource('evenements', EvenementController::class);
Route::resource('stands', StandController::class);
// Route::get('Tickets', [TicketController::class, 'index'])->name('Tickets.index');
Route::get('Tickets/{evenement}', [TicketController::class, 'show'])->name('Tickets.show');
Route::get('evenements/{evenement}', [EvenementController::class, 'show'])->name('evenements.show');

Route::resource('verkoper', VerkoperController::class);
Route::get('evenements/{evenement}', [EvenementController::class, 'show'])->name('evenements.show');
Route::post('/verkoper/create', [VerkoperController::class, 'store'])->name('verkoper.store');
Route::delete('/verkoper/{id}', [VerkoperController::class, 'destroy'])->name('verkoper.destroy');

// Admin routes for managing ticket prices (prijzen)
Route::prefix('admin/prijzen')->name('admin.prijzen.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/', [AdminController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdminController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('destroy');
});

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


