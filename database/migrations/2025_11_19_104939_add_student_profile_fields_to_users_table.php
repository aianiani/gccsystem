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
        Schema::table('users', function (Blueprint $table) {
            $table->string('contact_number', 20)->nullable()->after('email');
            $table->text('address')->nullable()->after('contact_number');
            $table->string('student_id', 50)->nullable()->after('address');
            $table->string('college', 255)->nullable()->after('student_id');
            $table->string('course', 255)->nullable()->after('college');
            $table->string('year_level', 50)->nullable()->after('course');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'contact_number',
                'address',
                'student_id',
                'college',
                'course',
                'year_level'
            ]);
        });
    }
};
