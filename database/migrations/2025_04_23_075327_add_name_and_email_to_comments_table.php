<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Add name column only if it doesn't exist
            if (!Schema::hasColumn('comments', 'name')) {
                $table->string('name')->after('post_id');
            }

            // Add email column only if it doesn't exist
            if (!Schema::hasColumn('comments', 'email')) {
                $table->string('email')->after(Schema::hasColumn('comments', 'name') ? 'name' : 'post_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            // Only drop columns that exist
            if (Schema::hasColumn('comments', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('comments', 'email')) {
                $table->dropColumn('email');
            }
        });
    }
};
