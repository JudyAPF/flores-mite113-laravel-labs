@extends('layouts.app')

@section('title', $student->name)

@section('content')

    <a href="{{ route('students.index') }}"
       class="text-sm font-medium text-ship-cove transition hover:text-lucky-point">
        &larr; Back to students
    </a>

    <div class="mt-4 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-lucky-point/10">

        <header class="bg-lucky-point px-8 py-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cornflower">
                Student Details
            </p>
            <h1 class="mt-2 text-3xl font-bold text-white">{{ $student->name }}</h1>
        </header>

        <dl class="grid gap-4 px-8 py-8 sm:grid-cols-2">
            <div class="rounded-xl bg-mystic p-4">
                <dt class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Student Number</dt>
                <dd class="mt-1 text-lg font-semibold">
                    @if ($student->student_number)
                        {{ $student->student_number }}
                    @else
                        <span class="font-normal text-ship-cove">Not assigned</span>
                    @endif
                </dd>
            </div>

            <div class="rounded-xl bg-mystic p-4">
                <dt class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Name</dt>
                <dd class="mt-1 text-lg font-semibold">{{ $student->name }}</dd>
            </div>

            <div class="rounded-xl bg-mystic p-4">
                <dt class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Email</dt>
                <dd class="mt-1 break-all text-lg font-semibold">{{ $student->email }}</dd>
            </div>

            <div class="rounded-xl bg-mystic p-4">
                <dt class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Year Level</dt>
                <dd class="mt-1 text-lg font-semibold">{{ $student->year_level }}</dd>
            </div>

            {{-- Reached through the belongsTo relationship, not a column on students. --}}
            <div class="rounded-xl bg-mystic p-4 sm:col-span-2">
                <dt class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Course</dt>
                <dd class="mt-1 text-lg font-semibold">
                    @if ($student->course)
                        {{ $student->course->code }}
                        <span class="font-normal text-ship-cove">&mdash; {{ $student->course->name }}</span>
                    @else
                        <span class="font-normal text-ship-cove">Not enrolled</span>
                    @endif
                </dd>
            </div>

            {{-- LAB 4: the owner. Also reached through a belongsTo relationship
                 (Student::user), which is exactly what StudentPolicy compares
                 the logged-in user against. --}}
            <div class="rounded-xl bg-mystic p-4 sm:col-span-2">
                <dt class="text-xs font-semibold uppercase tracking-wider text-ship-cove">Owner</dt>
                <dd class="mt-1 text-lg font-semibold">
                    @if ($student->user)
                        {{ $student->user->name }}
                        <span class="font-normal text-ship-cove">&mdash; {{ $student->user->email }}</span>
                        @if ($student->user_id === Auth::id())
                            <span class="ml-1 rounded bg-cornflower px-1.5 py-0.5 text-[10px]
                                         font-bold uppercase tracking-wide text-lucky-point">You</span>
                        @endif
                    @else
                        <span class="font-normal text-ship-cove">Unowned record</span>
                    @endif
                </dd>
            </div>
        </dl>

        <footer class="flex flex-wrap items-center gap-3 border-t border-mystic px-8 py-5">

            {{-- Same policy, checked again in a second place. The controller is
                 the real guard; these blocks just keep the UI honest. --}}
            @can('update', $student)
                <a href="{{ route('students.edit', $student) }}"
                   class="rounded-lg bg-lucky-point px-5 py-2.5 text-sm font-semibold text-white
                          transition hover:bg-ship-cove">Edit</a>
            @endcan

            @can('delete', $student)
                <form method="POST" action="{{ route('students.destroy', $student) }}"
                      onsubmit="return confirm('Delete {{ $student->name }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="rounded-lg px-4 py-2.5 text-sm font-medium text-red-600
                                   transition hover:bg-red-50">Delete</button>
                </form>
            @endcan

            @cannot('update', $student)
                <p class="text-sm text-ship-cove">
                    You are viewing someone else's record, so there is nothing to change here.
                </p>
            @endcannot

        </footer>

    </div>

@endsection
