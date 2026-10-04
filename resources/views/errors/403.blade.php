@extends('layouts.app')

@section('title', 'Not allowed')

@section('content')

    {{-- Laravel looks for resources/views/errors/{status}.blade.php automatically.
         Create 404.blade.php, 500.blade.php and so on the same way.
         $exception is passed in by the framework. --}}
    <div class="mx-auto max-w-md overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-lucky-point/10">

        <header class="bg-lucky-point px-8 py-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cornflower">
                Error 403
            </p>
            <h1 class="mt-2 text-2xl font-bold text-white">Forbidden</h1>
        </header>

        <div class="px-8 py-8">
            <p class="text-sm text-ship-cove">
                You are signed in, but this record belongs to someone else.
                Only its owner — or an admin — may edit or delete it.
            </p>

            <p class="mt-4 rounded-xl bg-mystic p-4 text-xs text-ship-cove">
                <span class="font-semibold uppercase tracking-wider text-lucky-point">What happened</span><br>
                StudentPolicy returned <span class="font-mono">false</span>, so
                <span class="font-mono">authorize()</span> stopped the request before the
                controller could touch the database.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('students.index') }}"
                   class="rounded-lg bg-lucky-point px-5 py-2.5 text-sm font-semibold text-white
                          transition hover:bg-ship-cove">Back to students</a>
                <a href="{{ route('dashboard') }}"
                   class="rounded-lg border border-cornflower px-5 py-2.5 text-sm font-semibold text-lucky-point
                          transition hover:bg-mystic">Dashboard</a>
            </div>
        </div>

    </div>

@endsection
