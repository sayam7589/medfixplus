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
        Schema::table('inventory', function (Blueprint $table) {
            $table->foreign('project_id')
                  ->references('id')
                  ->on('project')
                  ->onDelete('cascade');
            $table->foreign('inv_type')
                  ->references('id')
                  ->on('inventory_type')
                  ->onDelete('cascade');
            $table->foreign('inv_brand')
                  ->references('id')
                  ->on('inventory_brand')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    
    public function down()
    {
        Schema::table('inventory', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropForeign(['inv_type']);
            $table->dropForeign(['inv_brand']);
            $table->dropForeign(['inv_model_id']);
        });
    }
};
