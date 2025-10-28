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
        // First, make the catch_id columns nullable temporarily
        Schema::table('boats', function (Blueprint $table) {
            $table->unsignedBigInteger('catch_id')->nullable()->after('id');
        });

        Schema::table('fishing_operations', function (Blueprint $table) {
            $table->unsignedBigInteger('catch_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boats_and_fishing_operations', function (Blueprint $table) {
            //
        });
    }
};
