<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    /**
     * LAB 4: this is what makes $this->authorize('update', $student) exist.
     *
     * In Laravel 10 and earlier the base controller shipped with this trait
     * already applied. Since Laravel 11 the file is empty by default, so
     * calling $this->authorize() without adding it yourself fails with
     * "Call to undefined method ...::authorize()".
     *
     * Every controller in app/Http/Controllers extends this class, so adding
     * it once here gives all of them the helper.
     */
    use AuthorizesRequests;
}
