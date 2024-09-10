<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => 'Home']);
});
Route::get('/dashboard', function () {
    return view('dashboard', ['title' => 'Dashboard']);
});
