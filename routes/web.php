<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landingPage');
});
Route::get('/edukasi', function () {
    return view('educationPage');
});
