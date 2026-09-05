<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * The courses offered in the student form's dropdown.
     * updateOrCreate keyed on "code" makes this safe to re-run.
     */
    public function run(): void
    {
        $courses = [
            ['code' => 'BSIT', 'name' => 'BS Information Technology'],
            ['code' => 'BSA',  'name' => 'BS Accountancy'],
            ['code' => 'BCS',  'name' => 'BS Computer Science'],
        ];

        foreach ($courses as $course) {
            Course::updateOrCreate(['code' => $course['code']], $course);
        }
    }
}
