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
 * LAB 4: every method now passes through StudentPolicy first.
 *
 * Registered with Route::resource('students', StudentController::class)
 * INSIDE the auth middleware group, which maps the seven methods below onto
 * the seven REST routes:
 *
 *   GET    /students             index    list every student
 *   GET    /students/create      create   show the "Add Student" form
 *   POST   /students             store    save the new student
 *   GET    /students/{student}   show     one student's details
 *   GET    /students/{student}/edit  edit  show the "Update Student" form
 *   PUT    /students/{student}   update   save the edits
 *   DELETE /students/{student}   destroy  remove the student
 *
 * TWO DIFFERENT GATES, do not confuse them:
 *   auth middleware (routes/web.php) -> "are you logged in?"      -> redirect to /login
 *   $this->authorize() (here)        -> "are you allowed to?"     -> 403
 */
class StudentController extends Controller
{
    /**
     * List all students, newest first.
     *
     * with('course', 'user') eager-loads both relationships so the list does
     * not fire extra queries per student (the classic N+1 problem) — the
     * @can checks in the view read $student->user_id, and the "Owner" label
     * reads $student->user->name.
     */
    public function index(): View
    {
        // Student::class, not an instance: there is no single student to
        // check yet, so the policy gets only the user (viewAny).
        $this->authorize('viewAny', Student::class);

        $students = Student::with('course', 'user')->latest()->get();

        return view('students.index', compact('students'));
    }

    /**
     * Show the blank form. Courses fill the dropdown.
     */
    public function create(): View
    {
        $this->authorize('create', Student::class);

        return view('students.create', ['courses' => Course::orderBy('code')->get()]);
    }

    /**
     * Validate and save a new student.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', Student::class);

        $data = $this->validated($request);

        // Creating THROUGH the relationship is what stamps ownership:
        // Laravel fills user_id with the logged-in user's id for us.
        // This is why user_id is not in $fillable — the value comes from the
        // session, never from the submitted form.
        $request->user()->students()->create($data);

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
        $this->authorize('view', $student);

        $student->load('course', 'user');

        return view('students.show', compact('student'));
    }

    /**
     * Show the form pre-filled with this student's current values.
     *
     * Checked with 'update', not 'edit' — the policy has no edit() method,
     * and the form is only useful to someone allowed to submit it. Without
     * this line a stranger could open /students/1/edit, see the form, fill
     * it in, and only be stopped on submit. The activity checklist is
     * explicit: a non-owner must get a 403, NOT the edit form.
     */
    public function edit(Student $student): View
    {
        $this->authorize('update', $student);

        return view('students.edit', [
            'student' => $student,
            'courses' => Course::orderBy('code')->get(),
        ]);
    }

    /**
     * Validate and save the edits.
     *
     * authorize() FIRST, before validation and before touching the model.
     * It throws AuthorizationException, which Laravel renders as 403, so
     * nothing below this line runs for an unauthorized user.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $this->authorize('update', $student);

        $student->update($this->validated($request, $student));

        return redirect()->route('students.index')
            ->with('success', 'Student updated successfully.');
    }

    /**
     * Delete the student.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $this->authorize('delete', $student);

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
