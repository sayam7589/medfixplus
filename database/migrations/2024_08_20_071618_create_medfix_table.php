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
        Schema::create('medfix', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inv_id')->constrained('inventory')->onDelete('cascade');
            $table->integer('medfix_owner_prefix');
            $table->string('medfix_owner_fname');
            $table->string('medfix_owner_lname');
            $table->foreignId('medfix_user_id')->constrained('users')->onDelete('cascade');
            $table->string('medfix_user_org');
            $table->text('medfix_detail');
            $table->string('medfix_tel');
            $table->string('medfix_pic');
            $table->dateTime('medfix_ticket_date');
            $table->foreignId('medfix_technician_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('issue_id')->constrained('issue')->onDelete('cascade');
            $table->foreignId('solving_id')->constrained('solving')->onDelete('cascade');
            $table->text('medfix_technician_comment');
            $table->foreignId('medfix_upgrade_equipment')->constrained('equipment')->onDelete('cascade');
            $table->text('medfix_upgrade_detail');
            $table->integer('medfix_status');
            $table->dateTime('medfix_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medfix');
    }
};
