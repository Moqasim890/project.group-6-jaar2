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

