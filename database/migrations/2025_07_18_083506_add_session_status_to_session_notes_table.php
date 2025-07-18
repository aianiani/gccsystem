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
        Schema::table('session_notes', function (Blueprint $table) {
            $table->enum('session_status', ['scheduled', 'completed', 'missed', 'expired'])->default('scheduled')->after('next_session');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_notes', function (Blueprint $table) {
            $table->dropColumn('session_status');
        });
    }
};
