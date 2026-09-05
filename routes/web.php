<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Lab Activity 1 - Student Profile
|--------------------------------------------------------------------------
| GET /profile  ->  ProfileController@show  ->  resources/views/profile.blade.php
| The route is NAMED "profile.show" so we can link to it with route('profile.show').
*/
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');

/*
| EXTENSION / CHALLENGE: /profile/{name} reads the student from MySQL.
| Must be declared AFTER /profile so the static page still wins.
*/
Route::get('/profile/{name}', [ProfileController::class, 'showByName'])
    ->name('profile.showByName');
