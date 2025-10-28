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
        // Create roles table
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->timestamps();
            });

            // Insert default roles
            DB::table('roles')->insert([
                ['name' => 'BFAR Personnel', 'slug' => 'BFAR_PERSONNEL', 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Regional Admin', 'slug' => 'REGIONAL_ADMIN', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        // Add role_id to users table if it doesn't exist
        if (!Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('role_id')->after('id')->constrained('roles');
            });
        }

        // Remove any existing 'role' column if it exists
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key first to avoid constraint errors
        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['role_id']);
                $table->dropColumn('role_id');
            });
        }

        // Drop roles table if you want to rollback completely
        // Schema::dropIfExists('roles');
    }
};
