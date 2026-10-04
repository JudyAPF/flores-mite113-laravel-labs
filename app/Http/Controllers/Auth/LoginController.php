<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * LAB 4: session login and logout.
 *
 * Deliberately shaped like a CRUD controller, because that is what it is —
 * the resource being created and destroyed is the SESSION, not a user:
 *
 *   GET  /login   create   show the sign-in form
 *   POST /login   store    "create" a session  (log in)
 *   POST /logout  destroy  "delete" the session (log out)
 */
class LoginController extends Controller
{
    /**
     * Show the sign-in form.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Attempt to log the user in.
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. VALIDATE — make sure both fields actually arrived and look sane.
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. ATTEMPT — Auth::attempt() looks up the user by email, hashes the
        //    submitted password and compares it to the stored hash. It returns
        //    false on any mismatch; we never compare passwords ourselves.
        //    The second argument is "remember me": a long-lived cookie.
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            // One vague message on purpose. Saying "no such email" would let a
            // stranger discover which addresses are registered.
            throw ValidationException::withMessages([
                'email' => 'Those credentials do not match our records.',
            ]);
        }

        // 3. REGENERATE — issue a brand-new session ID now that privileges
        //    changed. Stops "session fixation", where an attacker plants a
        //    known session ID beforehand and inherits the login.
        $request->session()->regenerate();

        // 4. REDIRECT — intended() returns the user to the page the auth
        //    middleware bounced them away from; /dashboard is the fallback
        //    when they simply visited /login directly.
        return redirect()->intended(route('dashboard'))
            ->with('success', 'Welcome back, '.Auth::user()->name.'!');
    }

    /**
     * Log the user out.
     *
     * POST, never GET: a GET logout can be fired by any <img src="/logout">
     * on another site, and a plain link would be pre-fetched by browsers.
     * POST means the request must carry a CSRF token.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();                            // forget the user on the "web" guard
        $request->session()->invalidate();         // throw away all session data
        $request->session()->regenerateToken();    // rotate CSRF so old forms are dead

        return redirect()->route('login')
            ->with('success', 'You have been logged out.');
    }
}
