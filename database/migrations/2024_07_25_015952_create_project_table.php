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
        Schema::create('project', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_name')->nullable();
            $table->string('project_detail')->nullable();
            $table->string('project_company')->nullable();
            $table->string('project_company_contact')->nullable();
            $table->string('project_file')->nullable();
            $table->date('project_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('project');
    }
};
