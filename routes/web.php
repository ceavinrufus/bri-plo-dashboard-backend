<?php

use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });


Route::get('/', function () {
    return view('dashboard', ['title' => 'Dashboard']);
});



require __DIR__ . '/auth.php';
