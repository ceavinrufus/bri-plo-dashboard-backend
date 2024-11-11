<?php

use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return ['Laravel' => app()->version()];
// });


Route::get('/', function () {
    return "Welcome";
});



require __DIR__ . '/auth.php';
