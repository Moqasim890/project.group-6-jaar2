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
Route::resource('Tickets', TicketController::class);
Route::resource('verkoper', VerkoperController::class);
Route::post('/verkoper/create', [VerkoperController::class, 'store'])->name('verkoper.store');



// fallback: ALLES wat niet bestaat -> onderhoud
Route::fallback(function () {
    return redirect()->route('onderhoud');
});


