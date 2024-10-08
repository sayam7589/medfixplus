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
        Schema::create('personal_has_inv', function (Blueprint $table) {
            $table->id();
            $table->integer('prefix');
            $table->string('fname');
            $table->string('lname');
            $table->string('org')->nullable();
            $table->string('tel')->nullable();
            $table->integer('inv_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_has_invs');
    }
};
