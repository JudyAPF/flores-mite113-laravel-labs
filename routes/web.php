<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Lab Activity 1 - Student Profile  (public)
|--------------------------------------------------------------------------
| GET /profile  ->  ProfileController@show  ->  resources/views/profile.blade.php
| The route is NAMED "profile.show" so we can link to it with route('profile.show').
*/
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::redirect('/', '/profile');   // keeps the root working

/*
|--------------------------------------------------------------------------
| Lab Activity 4 - Authentication
|--------------------------------------------------------------------------
| The login form is a "guest only" area: someone already signed in has no
| business seeing it, so the guest middleware bounces them to /dashboard.
|
| The GET route MUST be named exactly "login". Laravel's auth middleware
| calls route('login') when it turns a guest away — rename it and every
| protected route throws "Route [login] not defined" instead of redirecting.
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

/*
| Logout is POST so it needs a CSRF token, and it only makes sense for
| someone who is actually logged in — hence the auth middleware.
*/
Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Protected area - everything below requires a logged-in user
|--------------------------------------------------------------------------
| The auth middleware runs BEFORE the controller. A guest never reaches
| StudentController at all; Laravel redirects them to route('login') first
| and remembers where they were headed, so intended() can send them back.
|
| Wrapping Route::resource in the group protects all seven student routes
| with one line — index, create, store, show, edit, update and destroy.
*/
Route::middleware('auth')->group(function () {

    // Landing page after login.
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'user'      => Auth::user(),
            'myCount'   => \App\Models\Student::where('user_id', Auth::id())->count(),
            'allCount'  => \App\Models\Student::count(),
        ]);
    })->name('dashboard');

    /*
    | Lab Activity 3 - Student CRUD, now behind the gate.
    |
    |   students.index    GET     /students
    |   students.create   GET     /students/create
    |   students.store    POST    /students
    |   students.show     GET     /students/{student}
    |   students.edit     GET     /students/{student}/edit
    |   students.update   PUT     /students/{student}
    |   students.destroy  DELETE  /students/{student}
    |
    | auth answers "is this a real, logged-in user?" only. Whether THIS user
    | may edit THIS student is authorization — enforced by StudentPolicy
    | inside the controller.
    */
    Route::resource('students', StudentController::class);
});

/*
| EXTENSION / CHALLENGE: /profile/{name} reads the student from MySQL.
| Must be declared AFTER /profile so the static page still wins.
*/
Route::get('/profile/{name}', [ProfileController::class, 'showByName'])
    ->name('profile.showByName');
