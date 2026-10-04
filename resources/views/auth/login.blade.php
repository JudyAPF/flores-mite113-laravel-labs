@extends('layouts.app')

@section('title', 'Log in')

@section('content')

    <div class="mx-auto max-w-md">

        <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-lucky-point/10">

            <header class="bg-lucky-point px-8 py-8">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cornflower">
                    {{ config('app.name') }}
                </p>
                <h1 class="mt-2 text-2xl font-bold text-white">Sign in</h1>
                <p class="mt-1 text-sm text-cornflower">
                    You need an account to manage students.
                </p>
            </header>

            {{-- Validation + failed-login errors.
                 Both the "required" rules and the ValidationException thrown
                 when Auth::attempt() fails land in the same $errors bag, so
                 one block displays either. --}}
            @if ($errors->any())
                <div class="border-l-4 border-red-400 bg-red-50 px-8 py-4">
                    <ul class="list-inside list-disc space-y-1 text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- POST /login -> LoginController@store.
                 @csrf writes a hidden token field. Without it Laravel rejects
                 the request with 419 Page Expired — that token is what proves
                 the form came from your own site. --}}
            <form method="POST" action="{{ route('login') }}" class="px-8 py-8">
                @csrf

                <div class="space-y-5">

                    <div>
                        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-ship-cove">
                            Email
                        </label>
                        {{-- old('email') refills the box after a failed attempt so
                             the user does not retype it. Never do this for a password. --}}
                        <input type="email" name="email" id="email"
                               value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               placeholder="you@example.com"
                               class="mt-2 w-full rounded-lg border border-cornflower bg-white px-4 py-2.5 text-lucky-point
                                      placeholder:text-ship-cove/60 focus:border-lucky-point focus:outline-none
                                      focus:ring-2 focus:ring-cornflower">
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-ship-cove">
                            Password
                        </label>
                        <input type="password" name="password" id="password"
                               required autocomplete="current-password"
                               placeholder="••••••••"
                               class="mt-2 w-full rounded-lg border border-cornflower bg-white px-4 py-2.5 text-lucky-point
                                      placeholder:text-ship-cove/60 focus:border-lucky-point focus:outline-none
                                      focus:ring-2 focus:ring-cornflower">
                    </div>

                    <label for="remember" class="flex items-center gap-2 text-sm text-ship-cove">
                        <input type="checkbox" name="remember" id="remember" value="1"
                               class="rounded border-cornflower text-lucky-point focus:ring-cornflower">
                        Remember me on this device
                    </label>

                </div>

                <button type="submit"
                        class="mt-8 w-full rounded-lg bg-lucky-point px-5 py-2.5 text-sm font-semibold text-white
                               transition hover:bg-ship-cove focus:outline-none focus:ring-2 focus:ring-cornflower">
                    Log in
                </button>

            </form>

        </div>

        {{-- Classroom convenience only. Delete this block before showing the
             project to anyone outside the lab. --}}
        <div class="mt-6 rounded-xl border border-cornflower bg-white/60 px-5 py-4 text-sm text-ship-cove">
            <p class="font-semibold uppercase tracking-wider text-lucky-point">Lab accounts</p>
            <p class="mt-2"><span class="font-semibold">judy@example.com</span> &middot; password</p>
            <p><span class="font-semibold">rico@example.com</span> &middot; password</p>
            <p><span class="font-semibold">admin@example.com</span> &middot; password &mdash; admin</p>
        </div>

    </div>

@endsection
