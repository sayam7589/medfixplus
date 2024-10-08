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
            $table->string('rec_prefix')->nullable(); 
            $table->string('rec_fname')->nullable(); 
            $table->string('rec_lname')->nullable(); 
            $table->integer('rec_personal_tel')->nullable(); 
            $table->integer('rec_org_tel')->nullable(); 
            $table->string('rec_organize')->nullable(); 
            $table->string('rec_address')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('inventory', function (Blueprint $table) {
            //
        });
    }
};
