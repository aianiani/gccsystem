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
        Schema::table('users', function (Blueprint $table) {
            // Composite index for role and registration_status (most frequently queried together)
            $table->index(['role', 'registration_status'], 'idx_role_registration_status');

            // Index for college filter
            $table->index('college', 'idx_college');

            // Index for course filter
            $table->index('course', 'idx_course');

            // Index for created_at (used in sorting and date filtering)
            $table->index('created_at', 'idx_created_at');

            // Index for approved_at (used in statistics)
            $table->index('approved_at', 'idx_approved_at');

            // Index for student_id (used in duplicate detection and search)
            $table->index('student_id', 'idx_student_id');

            // Composite index for duplicate detection (email + role)
            $table->index(['email', 'role'], 'idx_email_role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_role_registration_status');
            $table->dropIndex('idx_college');
            $table->dropIndex('idx_course');
            $table->dropIndex('idx_created_at');
            $table->dropIndex('idx_approved_at');
            $table->dropIndex('idx_student_id');
            $table->dropIndex('idx_email_role');
        });
    }
};
