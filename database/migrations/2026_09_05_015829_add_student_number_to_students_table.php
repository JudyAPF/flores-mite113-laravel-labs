<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * EXTENSION TASK: add a unique student_number column.
     *
     * It is nullable because the students table already has rows.
     * A NOT NULL unique column would give every existing row the same
     * empty value and break the unique rule.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('student_number')->nullable()->unique()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropUnique(['student_number']);
            $table->dropColumn('student_number');
        });
    }
};
