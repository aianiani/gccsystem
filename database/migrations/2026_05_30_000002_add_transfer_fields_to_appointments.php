<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->text('transfer_note')->nullable()->after('decline_reason');
            $table->unsignedBigInteger('transferred_from_counselor_id')->nullable()->after('transfer_note');
            $table->foreign('transferred_from_counselor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['transferred_from_counselor_id']);
            $table->dropColumn(['transfer_note', 'transferred_from_counselor_id']);
        });
    }
};
