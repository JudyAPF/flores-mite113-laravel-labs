<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'name',
        'email',
        'program',
        'year_level',
    ];
}
