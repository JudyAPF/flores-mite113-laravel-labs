<?php

namespace App\Http\Controllers;

use App\Models\Student;

class ProfileController extends Controller
{
    /**
     * LAB 1 (required): show the static student profile page.
     * Route: GET /profile   (named: profile.show)
     */
    public function show()
    {
        // Student data is kept here for now (Lab 1).
        // In Lab 2 this same kind of data is moved into the MySQL database.
        $student = [
            'name'        => 'Judy Ann P. Flores',
            'program'     => 'BSIT',
            'year_level'  => '3rd Year',
            'skills'      => ['Laravel & PHP', 'MySQL', 'Tailwind CSS', 'Java', 'Python', 'Flutter', 'Figma'],
            'career_goal' => 'To become a full-stack web developer who builds clean, '
                           . 'reliable systems that make everyday work easier for people.',
            // Lab 1 reads no database, so there is no students row to link to.
            // The view uses this to decide whether to show the record button.
            'studentId'   => null,
        ];

        // Pass the data to resources/views/profile.blade.php
        return view('profile', $student);
    }

    /**
     * EXTENSION / CHALLENGE: show any student by name, read from MySQL.
     * Route: GET /profile/{name}   (named: profile.showByName)
     *
     * This is where Lab 1 and Lab 2 meet: the page no longer uses a
     * hard-coded PHP array, it uses Eloquent to read the students table.
     */
    public function showByName(string $name)
    {
        // Eloquent query. firstOrFail() shows a 404 page if nobody matches.
        $student = Student::with('course')->where('name', $name)->firstOrFail();

        return view('profile', [
            // This profile IS a students row, so the view can link to its
            // CRUD detail page at /students/{id}.
            'studentId'   => $student->id,
            'name'        => $student->name,
            // The program is no longer a column on students - it now lives in
            // the related courses row, reached through the belongsTo relationship.
            'program'     => $student->course?->code ?? 'Not enrolled',
            'year_level'  => $student->year_level ?? 'Not set',
            'skills'      => ['Laravel & PHP', 'MySQL Database Design', 'Tailwind CSS'],
            'career_goal' => 'To become a full-stack web developer who builds clean, '
                           . 'reliable systems that make everyday work easier for people.',
        ]);
    }
}
