@extends('layouts.app')

@section('title', $name . ' — Student Profile')

@section('content')

<div class="mx-auto max-w-3xl">
    <div class="overflow-hidden rounded-2xl bg-white shadow-lg ring-1 ring-lucky-point/10">

        {{-- Header --}}
        <header class="bg-lucky-point px-8 py-10 text-center sm:text-left">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cornflower">
                Student Profile
            </p>
            <h1 class="mt-2 text-3xl font-bold text-white sm:text-4xl">
                {{ $name }}
            </h1>
            <p class="mt-2 text-cornflower">
                {{ $program }} &middot; {{ $year_level }}
            </p>
        </header>

        <div class="space-y-8 px-8 py-8">

            {{-- Details --}}
            <section class="grid gap-4 sm:grid-cols-2">
                <div class="rounded-xl bg-mystic p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Program</p>
                    <p class="mt-1 text-lg font-semibold">{{ $program }}</p>
                </div>
                <div class="rounded-xl bg-mystic p-4">
                    <p class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Year Level</p>
                    <p class="mt-1 text-lg font-semibold">{{ $year_level }}</p>
                </div>
            </section>

            {{-- Skills --}}
            <section>
                <h2 class="text-sm font-semibold uppercase tracking-wider text-ship-cove">Top Skills</h2>
                <ul class="mt-3 flex flex-wrap gap-2">
                    @foreach ($skills as $skill)
                        <li class="rounded-full bg-cornflower/30 px-4 py-2 text-sm font-medium text-lucky-point">
                            {{ $skill }}
                        </li>
                    @endforeach
                </ul>
            </section>

            {{-- Career goal --}}
            <section class="rounded-xl border-l-4 border-ship-cove bg-mystic p-5">
                <h2 class="text-sm font-semibold uppercase tracking-wider text-ship-cove">Career Goal</h2>
                <p class="mt-2 leading-relaxed">{{ $career_goal }}</p>
            </section>

        </div>

        {{-- Where to go next: every other page of the app, one click away. --}}
        <nav class="border-t border-mystic bg-mystic/50 px-8 py-6">
            <h2 class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Go to</h2>

            <div class="mt-3 flex flex-wrap gap-3">
                <a href="{{ route('students.index') }}"
                   class="rounded-lg bg-lucky-point px-5 py-2.5 text-sm font-semibold text-white
                          transition hover:bg-ship-cove focus:outline-none focus:ring-2 focus:ring-cornflower">
                    View All Students
                </a>

                <a href="{{ route('students.create') }}"
                   class="rounded-lg border border-lucky-point px-5 py-2.5 text-sm font-semibold text-lucky-point
                          transition hover:bg-lucky-point hover:text-white focus:outline-none focus:ring-2 focus:ring-cornflower">
                    Add a Student
                </a>

                {{-- Only on /profile/{name}, where the profile came from a real
                     students row and therefore has an id to link to. --}}
                @if ($studentId)
                    <a href="{{ route('students.show', $studentId) }}"
                       class="rounded-lg px-5 py-2.5 text-sm font-semibold text-ship-cove
                              transition hover:bg-white hover:text-lucky-point">
                        My Database Record &rarr;
                    </a>
                @endif
            </div>
        </nav>

        <footer class="border-t border-mystic px-8 py-4 text-center text-xs text-ship-cove">
            Route &rarr; Controller &rarr; View &nbsp;&middot;&nbsp;
            <span class="font-medium">{{ Route::currentRouteName() }}</span> &rarr;
            <span class="font-medium">{{ class_basename(Route::currentRouteAction()) }}</span> &rarr;
            <span class="font-medium">profile.blade.php</span>
        </footer>

    </div>
</div>

@endsection
