<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // First, drop the existing foreign key constraint if it exists
        Schema::table('boats', function (Blueprint $table) {
            // Check if the foreign key exists before trying to drop it
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $foreignKeys = $sm->listTableForeignKeys('boats');
            
            foreach ($foreignKeys as $foreignKey) {
                if ($foreignKey->getForeignTableName() === 'catches') {
                    $table->dropForeign(['fish_catch_id']);
                    break;
                }
            }
        });

        // Then modify the column to be nullable
        Schema::table('boats', function (Blueprint $table) {
            $table->unsignedBigInteger('fish_catch_id')->nullable()->change();
        });

        // Then add the foreign key constraint with onDelete('cascade')
        Schema::table('boats', function (Blueprint $table) {
            $table->foreign('fish_catch_id')
                  ->references('id')
                  ->on('catches')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop the foreign key constraint
        Schema::table('boats', function (Blueprint $table) {
            $table->dropForeign(['fish_catch_id']);
        });

        // Change the column back to not nullable
        Schema::table('boats', function (Blueprint $table) {
            $table->unsignedBigInteger('fish_catch_id')->nullable(false)->change();
        });
    }
};
