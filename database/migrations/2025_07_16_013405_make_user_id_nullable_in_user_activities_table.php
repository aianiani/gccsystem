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
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            // For SQLite, recreate the table
            Schema::create('user_activities_temp', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('action');
                $table->string('description')->nullable();
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->json('data')->nullable();
                $table->timestamps();
            });
            // Copy data
            \DB::statement('INSERT INTO user_activities_temp (id, user_id, action, description, ip_address, user_agent, data, created_at, updated_at) SELECT id, user_id, action, description, ip_address, user_agent, data, created_at, updated_at FROM user_activities');
            // Drop old table
            Schema::drop('user_activities');
            // Rename new table
            Schema::rename('user_activities_temp', 'user_activities');
        } else {
            Schema::table('user_activities', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            // For SQLite, recreate the table with NOT NULL
            Schema::create('user_activities_temp', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('action');
                $table->string('description')->nullable();
                $table->string('ip_address')->nullable();
                $table->string('user_agent')->nullable();
                $table->json('data')->nullable();
                $table->timestamps();
            });
            // Copy data (set user_id to 0 if null to avoid NOT NULL violation)
            \DB::statement('INSERT INTO user_activities_temp (id, user_id, action, description, ip_address, user_agent, data, created_at, updated_at) SELECT id, COALESCE(user_id, 0), action, description, ip_address, user_agent, data, created_at, updated_at FROM user_activities');
            Schema::drop('user_activities');
            Schema::rename('user_activities_temp', 'user_activities');
        } else {
            Schema::table('user_activities', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable(false)->change();
            });
        }
    }
};
