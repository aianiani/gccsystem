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
            $table->boolean('sms_notifications_enabled')->default(true)->after('email_verified_at');
            $table->timestamp('phone_verified_at')->nullable()->after('sms_notifications_enabled');
            $table->index('contact_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['contact_number']);
            $table->dropColumn(['sms_notifications_enabled', 'phone_verified_at']);
        });
    }
};
