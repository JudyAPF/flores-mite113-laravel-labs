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
}
