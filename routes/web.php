<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// ::class resolves in the namespace of the class
// https://www.php.net/manual/en/language.oop5.constants.php
// '->name' will give a name to the route, so it can be easily referenced by the route() 
// helper even if it changes the url in the future.
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']); // name inherited from get

Route::get('/posts', function () {
    return view('posts.index');
});
