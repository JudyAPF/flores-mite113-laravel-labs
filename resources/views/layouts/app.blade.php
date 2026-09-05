<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Students') — {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-mystic font-sans text-lucky-point antialiased">

    {{-- Top bar: on every page, so you are never more than one click from anywhere.
         The current section is highlighted with routeIs(). --}}
    <header class="bg-lucky-point">
        <div class="mx-auto flex max-w-4xl flex-wrap items-center justify-between gap-4 px-6 py-4">

            <a href="{{ route('profile.show') }}" class="text-lg font-bold text-white">
                {{ config('app.name') }}
            </a>

            @php
                $navBase   = 'rounded-lg px-4 py-2 text-sm font-medium transition';
                $navOn     = 'bg-white text-lucky-point shadow-sm';
                $navOff    = 'text-cornflower hover:bg-white/10 hover:text-white';
            @endphp

            <nav class="flex items-center gap-2">
                <a href="{{ route('profile.show') }}"
                   class="{{ $navBase }} {{ request()->routeIs('profile.*') ? $navOn : $navOff }}">
                    My Profile
                </a>
                <a href="{{ route('students.index') }}"
                   class="{{ $navBase }} {{ request()->routeIs('students.*') ? $navOn : $navOff }}">
                    Students
                </a>
                <a href="{{ route('students.create') }}"
                   class="{{ $navBase }} bg-cornflower text-lucky-point hover:bg-white">
                    + Add Student
                </a>
            </nav>

        </div>
    </header>

    <main class="mx-auto max-w-4xl px-6 py-10">

        {{-- Flash message set by ->with('success', ...) in the controller --}}
        @if (session('success'))
            <div class="mb-6 rounded-xl border-l-4 border-ship-cove bg-white px-5 py-4 text-sm font-medium shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
