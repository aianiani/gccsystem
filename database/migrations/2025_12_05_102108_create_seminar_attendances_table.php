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
        Schema::create('seminar_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('seminar_name'); // IDREAMS, 10C, LEADS, IMAGE
            $table->integer('year_level'); // 1, 2, 3, 4
            $table->date('attended_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'seminar_name', 'year_level']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminar_attendances');
    }
};
