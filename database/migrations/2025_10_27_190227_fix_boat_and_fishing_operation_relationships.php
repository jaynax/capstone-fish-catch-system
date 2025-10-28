<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, check if the catch_id column exists in boats table
        if (!Schema::hasColumn('boats', 'catch_id')) {
            Schema::table('boats', function (Blueprint $table) {
                $table->unsignedBigInteger('catch_id')->nullable()->after('id');
            });
        }

        // Check if the catch_id column exists in fishing_operations table
        if (!Schema::hasColumn('fishing_operations', 'catch_id')) {
            Schema::table('fishing_operations', function (Blueprint $table) {
                $table->unsignedBigInteger('catch_id')->nullable()->after('id');
            });
        }

        // Add foreign key constraints if they don't exist
        Schema::table('boats', function (Blueprint $table) {
            if (!Schema::hasColumn('boats', 'catch_id')) {
                $table->foreign('catch_id')
                      ->references('id')
                      ->on('catches')
                      ->onDelete('cascade');
            }
        });

        Schema::table('fishing_operations', function (Blueprint $table) {
            if (!Schema::hasColumn('fishing_operations', 'catch_id')) {
                $table->foreign('catch_id')
                      ->references('id')
                      ->on('catches')
                      ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove foreign key constraints
        if (Schema::hasColumn('boats', 'catch_id')) {
            Schema::table('boats', function (Blueprint $table) {
                $table->dropForeign(['catch_id']);
            });
        }

        if (Schema::hasColumn('fishing_operations', 'catch_id')) {
            Schema::table('fishing_operations', function (Blueprint $table) {
                $table->dropForeign(['catch_id']);
            });
        }
    }
};
