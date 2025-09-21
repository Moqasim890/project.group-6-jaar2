<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganisatorController;

Route::get('/verkopers', [OrganisatorController::class, 'GetAllVerkopers']);

Route::get('/', function () {
    return view('welcome');
});