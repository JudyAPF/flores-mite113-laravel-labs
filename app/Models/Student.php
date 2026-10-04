<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    use HasFactory;

    /**
     * Columns that are allowed to be mass-assigned,
     * e.g. Student::create([...]).
     * Without this, Laravel blocks the insert to protect you.
     *
     * NOTE: user_id is deliberately NOT here. The owner must never come from
     * the form — otherwise a visitor could post user_id=1 and hand themselves
     * someone else's record. The controller sets it from the session instead.
     */
    protected $fillable = [
        'student_number',
        'course_id',
        'name',
        'email',
        'year_level',
    ];

    /**
     * The other half of Course::students().
     * $student->course returns the Course this student belongs to,
     * or null while the student has no course set.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * LAB 4: the User who created / owns this record.
     * $student->user gives the owner, or null for an old unowned row.
     * This is the value StudentPolicy compares against.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
