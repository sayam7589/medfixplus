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
        Schema::create('receiver', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('inv_id');
            $table->unsignedBigInteger('rec_prefix');
            $table->string('rec_fname');
            $table->string('rec_lname');
            $table->string('rec_org_tel')->nullable();
            $table->unsignedBigInteger('rec_organize');
            $table->string('rec_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('receiver');
    }
};
