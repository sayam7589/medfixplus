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
        Schema::table('receiver', function (Blueprint $table) {
            $table->foreign('inv_id')
                  ->references('id')
                  ->on('inventory')
                  ->onDelete('cascade');
            $table->foreign('rec_prefix')
                  ->references('id')
                  ->on('prefix')
                  ->onDelete('cascade');
            $table->foreign('rec_organize')
                  ->references('id')
                  ->on('organize')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('receiver', function (Blueprint $table) {
            $table->dropForeign(['inv_id']);
            $table->dropForeign(['rec_prefix']);
            $table->dropForeign(['rec_organize']);
        });
    }
};
