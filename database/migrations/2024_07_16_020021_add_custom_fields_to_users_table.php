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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique();
            $table->string('rank')->nullable();
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('position')->nullable();
            $table->string('orgname')->nullable();
            $table->dropColumn('email');
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('rank');
            $table->dropColumn('fname');
            $table->dropColumn('lname');
            $table->dropColumn('position');
            $table->dropColumn('orgname');
            $table->string('email')->unique();
            $table->string('name');
        });
    }
};
