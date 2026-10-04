<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * LAB 4: a simple role flag.
     *
     * The activity allows the policy to pass when the user "owns the record
     * (or is an admin)". One boolean column is the smallest way to express
     * that — default false, so every existing and future user is a normal
     * user until someone is deliberately promoted.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false)->after('password');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
};
