@extends('layouts.app')

@section('title', 'Students')

@section('content')


    <div class="mb-6 flex items-center justify-between gap-4">
        <h1 class="text-2xl font-bold">Students</h1>
        <p class="mt-1 text-sm text-ship-cove">
            {{ $students->count() }} {{ Str::plural('record', $students->count()) }}
        </p>
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
                        </p>
                        <p class="mt-0.5 truncate text-sm text-ship-cove">{{ $student->email }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('students.show', $student) }}"
                            class="rounded-lg px-3 py-2 text-sm font-medium text-lucky-point
                                  transition hover:bg-mystic">View
                            Details</a>

                        <a href="{{ route('students.edit', $student) }}"
                            class="rounded-lg px-3 py-2 text-sm font-medium text-lucky-point
                                  transition hover:bg-mystic">Edit</a>

                        {{-- Delete has to be a form: a plain link cannot send DELETE. --}}
                        <form method="POST" action="{{ route('students.destroy', $student) }}"
                            onsubmit="return confirm('Delete {{ $student->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="rounded-lg px-3 py-2 text-sm font-medium text-red-600
                                           transition hover:bg-red-50">Delete</button>
                        </form>
                    </div>

                </li>
            @empty
                <li class="px-6 py-14 text-center">
                    <p class="text-sm text-ship-cove">No students yet.</p>
                    <a href="{{ route('students.create') }}"
                        class="mt-2 inline-block text-sm font-semibold text-lucky-point underline
                              underline-offset-4 hover:text-ship-cove">
                        Add the first one
                    </a>
                </li>
            @endforelse
        </ul>
    </div>

@endsection
