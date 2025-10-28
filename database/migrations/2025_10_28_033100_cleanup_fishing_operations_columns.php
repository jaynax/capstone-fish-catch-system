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
        // First, drop the foreign key constraints
        Schema::table('fishing_operations', function (Blueprint $table) {
            // Drop the catch_id column since we're using fish_catch_id
            if (Schema::hasColumn('fishing_operations', 'catch_id')) {
                // Drop foreign key constraint first if it exists
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $foreignKeys = $sm->listTableForeignKeys('fishing_operations');
                
                foreach ($foreignKeys as $foreignKey) {
                    if (in_array('catch_id', $foreignKey->getLocalColumns())) {
                        $table->dropForeign([$foreignKey->getLocalColumns()[0]]);
                        break;
                    }
                }
                
                $table->dropColumn('catch_id');
            }

            // Make sure fish_catch_id is not nullable
            $table->unsignedBigInteger('fish_catch_id')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Re-add the catch_id column if rolling back
        Schema::table('fishing_operations', function (Blueprint $table) {
            if (!Schema::hasColumn('fishing_operations', 'catch_id')) {
                $table->unsignedBigInteger('catch_id')->after('id');
                $table->foreign('catch_id')
                      ->references('id')
                      ->on('catches')
                      ->onDelete('cascade');
            }
        });
    }
};
