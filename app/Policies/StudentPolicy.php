<?php

namespace App\Policies;

use App\Models\Student;
use App\Models\User;

/**
 * LAB 4: every authorization rule for the Student model, in one class.
 *
 * AUTO-DISCOVERY
 * Laravel matches App\Models\Student to App\Policies\StudentPolicy by name,
 * so there is nothing to register anywhere. Rename either class and the
 * link silently breaks.
 *
 * HOW IT IS CALLED
 * The method name is the "ability":
 *   $this->authorize('update', $student)   -> StudentPolicy::update()
 *   @can('delete', $student)               -> StudentPolicy::delete()
 *   Route middleware 'can:update,student'  -> StudentPolicy::update()
 *
 * The first argument is always the logged-in User — Laravel injects it, you
 * never pass it. A guest never gets here at all: with no user to pass in,
 * Laravel denies automatically.
 */
class StudentPolicy
{
    /**
     * See the list of students.
     * Any signed-in user may browse the directory.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * See one student's detail page.
     * Reading is open to all signed-in users; only CHANGING is restricted.
     * This is what lets a non-owner open a record and find the Edit and
     * Delete buttons simply absent.
     */
    public function view(User $user, Student $student): bool
    {
        return true;
    }

    /**
     * Add a new student. Anyone signed in may do this — they become the owner.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Edit this student.
     *
     * THE CORE RULE: true only if the logged-in user owns this record,
     * or is an admin.
     *
     * === is strict comparison — same value AND same type. $user->id is an
     * int; if $student->user_id ever came back as the string "3", a loose ==
     * would call them equal. Strict comparison keeps the rule honest.
     *
     * The owns() helper below also guards the null case: an old student row
     * with user_id = NULL has no owner, so nobody but an admin may touch it.
     */
    public function update(User $user, Student $student): bool
    {
        return $this->owns($user, $student) || $user->is_admin;
    }

    /**
     * Delete this student. Same rule as update.
     */
    public function delete(User $user, Student $student): bool
    {
        return $this->owns($user, $student) || $user->is_admin;
    }

    /**
     * Shared ownership test, so update() and delete() cannot drift apart.
     *
     * $student->user_id is the raw foreign key — no extra query.
     * (Writing $student->user->id would load the whole User row from the
     * database and crash with "property on null" when there is no owner.)
     */
    private function owns(User $user, Student $student): bool
    {
        return $student->user_id !== null
            && $student->user_id === $user->id;
    }
}
