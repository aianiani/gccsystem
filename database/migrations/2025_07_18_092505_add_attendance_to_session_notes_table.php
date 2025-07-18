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
            $table->enum('attendance', ['attended', 'missed', 'unknown'])->default('unknown')->after('session_status');
            $table->string('absence_reason')->nullable()->after('attendance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_notes', function (Blueprint $table) {
            $table->dropColumn(['attendance', 'absence_reason']);
        });
    }
};
