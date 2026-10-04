@extends('layouts.app')

@section('title', 'Students')

@section('content')

    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold">Students</h1>
            <p class="mt-1 text-sm text-ship-cove">
                {{ $students->count() }} {{ Str::plural('record', $students->count()) }} &middot;
                you may edit the ones you own
            </p>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-lucky-point/10">
        <ul class="divide-y divide-mystic">
            @forelse ($students as $student)
                <li class="flex flex-wrap items-center justify-between gap-4 px-6 py-5">

                    <div class="min-w-0">
                        <p class="truncate font-semibold">
                            {{ $student->name }}
                            <span class="text-ship-cove">&ndash;</span>
                            <span class="text-ship-cove">{{ $student->course?->code ?? 'No course' }}</span>

                            {{-- A visible badge on your own records, so the lesson is
                                 obvious while testing: the rows with "Mine" are exactly
                                 the rows that still show Edit and Delete. --}}
                            @if ($student->user_id === Auth::id())
                                <span class="ml-1 rounded bg-cornflower px-1.5 py-0.5 text-[10px]
                                             font-bold uppercase tracking-wide text-lucky-point">Mine</span>
                            @endif
                        </p>
                        <p class="mt-0.5 truncate text-sm text-ship-cove">
                            {{ $student->email }}
                            <span class="text-ship-cove/60">&middot; added by {{ $student->user?->name ?? 'no one' }}</span>
                        </p>
                    </div>

                    <div class="flex items-center gap-2">

                        {{-- @can('view', $student) -> StudentPolicy::view().
                             Blade passes the logged-in user for you. --}}
                        @can('view', $student)
                            <a href="{{ route('students.show', $student) }}"
                                class="rounded-lg px-3 py-2 text-sm font-medium text-lucky-point
                                      transition hover:bg-mystic">View Details</a>
                        @endcan

                        {{-- Shown only when StudentPolicy::update() returns true,
                             i.e. the owner or an admin. Everyone else simply never
                             sees the button.

                             REMEMBER: this only hides the link. The real protection is
                             $this->authorize('update', $student) inside the controller
                             — a stranger who types /students/1/edit still gets a 403. --}}
                        @can('update', $student)
                            <a href="{{ route('students.edit', $student) }}"
                                class="rounded-lg px-3 py-2 text-sm font-medium text-lucky-point
                                      transition hover:bg-mystic">Edit</a>
                        @endcan

                        @can('delete', $student)
                            {{-- Delete has to be a form: a plain link cannot send DELETE. --}}
                            <form method="POST" action="{{ route('students.destroy', $student) }}"
                                onsubmit="return confirm('Delete {{ $student->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="rounded-lg px-3 py-2 text-sm font-medium text-red-600
                                               transition hover:bg-red-50">Delete</button>
                            </form>
                        @endcan

                        {{-- @cannot is the inverse of @can — a small hint in place of
                             the buttons, so the row does not look broken. --}}
                        @cannot('update', $student)
                            <span class="rounded-lg px-3 py-2 text-xs text-ship-cove/70">View only</span>
                        @endcannot

                    </div>

                </li>
            @empty
                <li class="px-6 py-14 text-center">
                    <p class="text-sm text-ship-cove">No students yet.</p>
                    @can('create', App\Models\Student::class)
                        <a href="{{ route('students.create') }}"
                            class="mt-2 inline-block text-sm font-semibold text-lucky-point underline
                                  underline-offset-4 hover:text-ship-cove">
                            Add the first one
                        </a>
                    @endcan
                </li>
            @endforelse
        </ul>
    </div>

@endsection
