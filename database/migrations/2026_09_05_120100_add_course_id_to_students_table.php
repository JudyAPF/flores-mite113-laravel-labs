<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * LAB 3: link every student to a row in "courses".
     *
     * Three steps, in this order:
     *   1. add the course_id foreign key (nullable, so existing rows survive)
     *   2. copy each old "program" string into courses and point the student at it
     *   3. drop the now-duplicated "program" column
     *
     * year_level also becomes nullable: the student form only asks for
     * name / email / course, so new records leave it empty.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('course_id')
                ->nullable()
                ->after('student_number')
                ->constrained()        // -> courses.id
                ->nullOnDelete();      // deleting a course leaves the student, course blank

            $table->string('year_level')->nullable()->change();
        });

        // --- Backfill: turn the old text column into real course rows ---
        $names = [
            'BSIT' => 'BS Information Technology',
            'BSA'  => 'BS Accountancy',
            'BCS'  => 'BS Computer Science',
        ];

        $programs = DB::table('students')
            ->whereNotNull('program')
            ->where('program', '<>', '')
            ->distinct()
            ->pluck('program');

        foreach ($programs as $program) {
            $courseId = DB::table('courses')->where('code', $program)->value('id')
                ?? DB::table('courses')->insertGetId([
                    'code'       => $program,
                    'name'       => $names[$program] ?? $program,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            DB::table('students')->where('program', $program)->update(['course_id' => $courseId]);
        }

        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('program');
        });
    }

    /**
     * Reverse it: rebuild "program" from the related course, then drop the key.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('program')->nullable()->after('email');
        });

        DB::table('students')
            ->join('courses', 'students.course_id', '=', 'courses.id')
            ->update(['students.program' => DB::raw('courses.code')]);

        Schema::table('students', function (Blueprint $table) {
            $table->dropConstrainedForeignId('course_id');
        });
    }
};
