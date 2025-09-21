<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganisatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/verkopers', [OrganisatorController::class, 'GetAllVerkopers']);