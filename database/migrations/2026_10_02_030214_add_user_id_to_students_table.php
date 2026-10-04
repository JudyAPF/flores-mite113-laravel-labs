<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * LAB 4: record WHO owns each student row.
     *
     * Authorization needs something to compare against. A policy asks
     * "is $user->id the same as this record's owner?" — but until now the
     * students table had no owner column at all, so there was nothing to ask.
     *
     * nullable() because the table already has rows: a NOT NULL column would
     * need a value for them, and we do not know yet which user that is.
     * The seeder backfills them afterwards.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->nullable()
                ->after('id')
                ->constrained()        // -> users.id, the database enforces it
                ->nullOnDelete();      // delete a user and their students survive, just unowned
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // drops the foreign key constraint AND the column, in the right order
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
