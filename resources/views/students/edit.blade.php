@extends('layouts.app')

@section('title', 'Edit ' . $student->name)

@section('content')

    <div class="mb-6">
        <h1 class="text-2xl font-bold">Edit Student</h1>
        <p class="mt-1 text-sm text-ship-cove">Update {{ $student->name }}'s details.</p>
    </div>

    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-lucky-point/10">
        {{-- Browsers can only send GET and POST, so @method('PUT') tells
             Laravel to route this to StudentController@update. --}}
        <form method="POST" action="{{ route('students.update', $student) }}">
            @csrf
            @method('PUT')

            @include('students._form', [
                'student'     => $student,
                'courses'     => $courses,
                'submitLabel' => 'Update Student',
            ])
        </form>
    </div>

@endsection
