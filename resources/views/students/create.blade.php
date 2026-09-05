@extends('layouts.app')

@section('title', 'Add Student')

@section('content')

    <div class="mb-6">
        <h1 class="text-2xl font-bold">Add Student</h1>
        <p class="mt-1 text-sm text-ship-cove">Fill in the details and pick a course.</p>
    </div>

    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-lucky-point/10">
        <form method="POST" action="{{ route('students.store') }}">
            @csrf

            @include('students._form', [
                'student'     => new \App\Models\Student(),
                'courses'     => $courses,
                'submitLabel' => 'Add Student',
            ])
        </form>
    </div>

@endsection
