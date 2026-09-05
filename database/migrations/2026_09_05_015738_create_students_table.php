<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations. (php artisan migrate)
     * This builds the "students" table in MySQL.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();                              // auto-increment primary key
            $table->string('name');                    // required
            $table->string('email')->unique();         // no two students share an email
            $table->string('program');                 // e.g. BSIT
            $table->string('year_level');              // e.g. 3rd Year
            $table->timestamps();                      // created_at + updated_at
        });
    }

    /**
     * Reverse the migrations. (php artisan migrate:rollback)
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
