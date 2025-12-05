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
        Schema::table('seminar_attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('seminar_schedule_id')->nullable()->after('year_level');
            $table->foreign('seminar_schedule_id')->references('id')->on('seminar_schedules')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminar_attendances', function (Blueprint $table) {
            $table->dropForeign(['seminar_schedule_id']);
            $table->dropColumn('seminar_schedule_id');
        });
    }
};
