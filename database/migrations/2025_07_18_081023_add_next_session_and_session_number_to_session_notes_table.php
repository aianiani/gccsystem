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
            $table->integer('session_number')->nullable()->after('note');
            $table->datetime('next_session')->nullable()->after('session_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_notes', function (Blueprint $table) {
            $table->dropColumn(['session_number', 'next_session']);
        });
    }
};
