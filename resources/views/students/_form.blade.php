{{--
    Shared by create.blade.php and edit.blade.php so the fields are written once.
    Expects: $student (a Student, or a new empty one) and $courses.
--}}

{{-- Validation summary --}}
@if ($errors->any())
    <div class="mb-6 rounded-xl border-l-4 border-red-400 bg-red-50 px-5 py-4">
        <p class="text-sm font-semibold text-red-800">Please fix the following:</p>
        <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-5 sm:grid-cols-2">

    {{-- Name --}}
    <div>
        <label for="name" class="block text-xs font-semibold uppercase tracking-wider text-ship-cove">
            Name
        </label>
        <input type="text" name="name" id="name"
               value="{{ old('name', $student->name) }}"
               required autofocus
               class="mt-2 w-full rounded-lg border border-cornflower bg-white px-4 py-2.5 text-lucky-point
                      placeholder:text-ship-cove/60 focus:border-lucky-point focus:outline-none
                      focus:ring-2 focus:ring-cornflower">
    </div>

    {{-- Email --}}
    <div>
        <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-ship-cove">
            Email
        </label>
        <input type="email" name="email" id="email"
               value="{{ old('email', $student->email) }}"
               required
               class="mt-2 w-full rounded-lg border border-cornflower bg-white px-4 py-2.5 text-lucky-point
                      placeholder:text-ship-cove/60 focus:border-lucky-point focus:outline-none
                      focus:ring-2 focus:ring-cornflower">
    </div>

    {{-- Course: the dropdown is built from the courses table --}}
    <div class="sm:col-span-2">
        <label for="course_id" class="block text-xs font-semibold uppercase tracking-wider text-ship-cove">
            Course
        </label>
        <select name="course_id" id="course_id" required
                class="mt-2 w-full rounded-lg border border-cornflower bg-white px-4 py-2.5 text-lucky-point
                       focus:border-lucky-point focus:outline-none focus:ring-2 focus:ring-cornflower">
            @foreach ($courses as $course)
                <option value="{{ $course->id }}"
                    @selected(old('course_id', $student->course_id) == $course->id)>
                    {{ $course->code }} — {{ $course->name }}
                </option>
            @endforeach
        </select>
    </div>

</div>

<div class="mt-8 flex items-center gap-3">
    <button type="submit"
            class="rounded-lg bg-lucky-point px-5 py-2.5 text-sm font-semibold text-white
                   transition hover:bg-ship-cove focus:outline-none focus:ring-2 focus:ring-cornflower">
        {{ $submitLabel }}
    </button>
    <a href="{{ route('students.index') }}"
       class="rounded-lg px-4 py-2.5 text-sm font-medium text-ship-cove transition hover:text-lucky-point">
        Cancel
    </a>
</div>
