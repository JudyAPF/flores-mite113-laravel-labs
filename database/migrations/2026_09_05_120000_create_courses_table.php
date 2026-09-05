<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * LAB 3: the "courses" table.
     *
     * A course used to be typed straight into the students table as a plain
     * string ("BSIT"). That repeats the same text on every row and lets typos
     * in. Giving courses their own table means the name is stored once and
     * every student simply points at it.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();                        // auto-increment primary key
            $table->string('code')->unique();    // e.g. BSIT - shown in the dropdown
            $table->string('name');              // e.g. BS Information Technology
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
