@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- Only reachable through the auth middleware group, so $user is
         guaranteed to exist here — no null checks needed. --}}
    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-lucky-point/10">

        <header class="bg-lucky-point px-8 py-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cornflower">
                Signed in
            </p>
            <h1 class="mt-2 text-3xl font-bold text-white">Hello, {{ $user->name }}</h1>
            <p class="mt-1 text-sm text-cornflower">{{ $user->email }}</p>
        </header>

        <dl class="grid gap-4 px-8 py-8 sm:grid-cols-3">

            <div class="rounded-xl bg-mystic p-4">
                <dt class="text-xs font-semibold uppercase tracking-wider text-ship-cove">My students</dt>
                <dd class="mt-1 text-2xl font-bold">{{ $myCount }}</dd>
                <p class="mt-1 text-xs text-ship-cove">Records you can edit and delete</p>
            </div>

            <div class="rounded-xl bg-mystic p-4">
                <dt class="text-xs font-semibold uppercase tracking-wider text-ship-cove">All students</dt>
                <dd class="mt-1 text-2xl font-bold">{{ $allCount }}</dd>
                <p class="mt-1 text-xs text-ship-cove">Records you can view</p>
            </div>

            <div class="rounded-xl bg-mystic p-4">
                <dt class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Role</dt>
                <dd class="mt-1 text-2xl font-bold">{{ $user->is_admin ? 'Admin' : 'Member' }}</dd>
                <p class="mt-1 text-xs text-ship-cove">
                    {{ $user->is_admin ? 'May edit any record' : 'May edit only your own' }}
                </p>
            </div>

        </dl>

        <footer class="flex flex-wrap items-center gap-3 border-t border-mystic px-8 py-5">
            <a href="{{ route('students.index') }}"
               class="rounded-lg bg-lucky-point px-5 py-2.5 text-sm font-semibold text-white
                      transition hover:bg-ship-cove">Browse students</a>
            <a href="{{ route('students.create') }}"
               class="rounded-lg border border-cornflower px-5 py-2.5 text-sm font-semibold text-lucky-point
                      transition hover:bg-mystic">Add a student</a>
        </footer>

    </div>

@endsection
