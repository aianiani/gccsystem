<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('assessments', function (Blueprint $table) {
            $table->json('score')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Warn: This destroys data, but reversion from JSON to Float is lossy anyway
        Schema::table('assessments', function (Blueprint $table) {
            $table->dropColumn('score');
        });

        Schema::table('assessments', function (Blueprint $table) {
            $table->float('score')->nullable();
        });
    }
};
