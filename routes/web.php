<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\Routing\Annotation\Route as AnnotationRoute;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tickets', function () {
    return view('tickets.index');
})->name('tickets.index');

Route::get('/tickets/kopen', function () {
    return view('tickets.kopen');
})->name('tickets.kopen');
