<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

Route::get('/about', function (){
    return view('pages.about');
})->name('about');
