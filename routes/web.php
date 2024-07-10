<?php

use Illuminate\Support\Facades\Route;

Route::get('/{any}', function () {
    return view('welcome'); // Ensure this view points to your main Vue template
})->where('any', '.*');