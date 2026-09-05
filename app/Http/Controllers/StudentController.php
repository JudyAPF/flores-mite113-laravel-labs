<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * LAB 3: full CRUD for students.
 *
 * Registered with Route::resource('students', StudentController::class),
 * which maps the seven methods below onto the seven REST routes:
 *
 *   GET    /students             index    list every student
 *   GET    /students/create      create   show the "Add Student" form
 *   POST   /students             store    save the new student
 *   GET    /students/{student}   show     one student's details
 *   GET    /students/{student}/edit  edit  show the "Update Student" form
 *   PUT    /students/{student}   update   save the edits
 *   DELETE /students/{student}   destroy  remove the student
 */
class StudentController extends Controller
{
    /**
     * List all students, newest first.
     * with('course') eager-loads the relationship so the list does not
     * fire one extra query per student (the classic N+1 problem).
     */
    public function index(): View
    {
        $students = Student::with('course')->latest()->get();

        return view('students.index', compact('students'));
    }

    /**
     * Show the blank form. Courses fill the dropdown.
     */
    public function create(): View
    {
        return view('students.create', ['courses' => Course::orderBy('code')->get()]);
    }

    /**
     * Validate and save a new student.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Student::create($data);

        return redirect()->route('students.index')
            ->with('success', 'Student created successfully.');
    }

    /**
     * One student's detail page.
     * The {student} route parameter is resolved into a Student by
     * Laravel's route-model binding (404 automatically if the id is unknown).
     */
    public function show(Student $student): View
    {
        $student->load('course');

        return view('students.show', compact('student'));
    }

    /**
     * Show the form pre-filled with this student's current values.
     */
    public function edit(Student $student): View
    {
        return view('students.edit', [
            'student' => $student,
            'courses' => Course::orderBy('code')->get(),
        ]);
    }

    /**
     * Validate and save the edits.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $student->update($this->validated($request, $student));

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Delete the student.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully.');
    }

    /**
     * The rules are identical for store() and update(), except that on update
     * the student is allowed to keep their own email address.
     */
    private function validated(Request $request, ?Student $student = null): array
    {
        return $request->validate([
            'student_number' => [
                'required',
                'string',
                'max:255',
                // the column is unique, so no two students may share a number
                Rule::unique('students', 'student_number')->ignore($student),
            ],
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($student),
            ],
            'year_level' => ['required', 'string', 'max:255'],
            // exists: the chosen id must be a real row in the courses table
            'course_id' => ['required', 'integer', Rule::exists('courses', 'id')],
        ], [
            'student_number.required' => 'Please enter a student number.',
            'student_number.unique'   => 'That student number is already taken.',
            'year_level.required'     => 'Please choose a year level.',
            'course_id.required'      => 'Please choose a course.',
            'course_id.exists'        => 'That course does not exist.',
        ]);
    }
}
