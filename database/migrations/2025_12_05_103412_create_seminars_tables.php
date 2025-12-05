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
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // IDREAMS, 10C, LEADS, IMAGE
            $table->text('description')->nullable();
            $table->integer('target_year_level'); // 1, 2, 3, 4
            $table->timestamps();
        });

        Schema::create('seminar_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seminar_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('location')->nullable();
            $table->string('academic_year')->nullable(); // e.g., "2025-2026"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminars_tables');
    }
};
