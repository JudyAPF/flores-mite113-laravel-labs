<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lab Activity 1 - Student Profile
|--------------------------------------------------------------------------
| GET /profile  ->  ProfileController@show  ->  resources/views/profile.blade.php
| The route is NAMED "profile.show" so we can link to it with route('profile.show').
*/
Route::get('/', [ProfileController::class, 'show'])->name('profile.show');

/*
|--------------------------------------------------------------------------
| Lab Activity 3 - Student CRUD
|--------------------------------------------------------------------------
| One line registers all seven RESTful routes:
|
|   students.index    GET     /students
|   students.create   GET     /students/create
|   students.store    POST    /students
|   students.show     GET     /students/{student}
|   students.edit     GET     /students/{student}/edit
|   students.update   PUT     /students/{student}
|   students.destroy  DELETE  /students/{student}
|
| Declared BEFORE /profile/{name} so "students" is never mistaken for a name.
*/
Route::resource('students', StudentController::class);

/*
| EXTENSION / CHALLENGE: /profile/{name} reads the student from MySQL.
| Must be declared AFTER /profile so the static page still wins.
*/
Route::get('/profile/{name}', [ProfileController::class, 'showByName'])
    ->name('profile.showByName');
