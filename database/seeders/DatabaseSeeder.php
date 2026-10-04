<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CourseSeeder::class);

        /*
         * LAB 4, instruction 7: "Create a second user record."
         *
         * You cannot test ownership with one account. Judy owns a record,
         * Rico owns a different one, and each should be blocked from the
         * other's — that is the whole point of the policy.
         *
         * firstOrCreate keeps `php artisan db:seed` safe to run more than once:
         * it looks the row up by the first array, and only inserts (merging in
         * the second array) when nothing is found.
         *
         * The password is written in plain text on purpose — the 'hashed' cast
         * on the User model turns it into a bcrypt hash on save. Never store
         * a password as plain text yourself.
         */
        $judy = User::firstOrCreate(
            ['email' => 'judy@example.com'],
            ['name' => 'Judy Ann Flores', 'password' => 'password', 'is_admin' => false],
        );

        $rico = User::firstOrCreate(
            ['email' => 'rico@example.com'],
            ['name' => 'Rico Dela Cruz', 'password' => 'password', 'is_admin' => false],
        );

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Site Admin', 'password' => 'password', 'is_admin' => true],
        );

        /*
         * Backfill: the add_user_id migration left every existing student with
         * user_id = NULL, and an unowned record is editable by nobody. Hand the
         * old rows to Judy so there is something to log in and edit.
         */
        Student::whereNull('user_id')->update(['user_id' => $judy->id]);

        /*
         * Give Rico one student of his own, so you can log in as him and see
         * Judy's rows become read-only — and hers do the same to him.
         */
        $rico->students()->firstOrCreate(
            ['email' => 'rico.student@example.com'],
            [
                'student_number' => '2026-00999',
                'name'           => "Rico's Student",
                'year_level'     => '2nd Year',
                'course_id'      => \App\Models\Course::orderBy('id')->value('id'),
            ],
        );

        /*
         * NOTE the shape above: $rico->students()->firstOrCreate(...), not
         * Student::firstOrCreate([... 'user_id' => $rico->id ...]).
         * user_id is not in $fillable, so passing it in the array would be
         * SILENTLY DISCARDED — no error, just an unowned student. Going
         * through the relationship sets the foreign key directly instead.
         */
    }
}
