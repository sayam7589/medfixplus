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
        //
        Schema::table('issue', function (Blueprint $table) {
            // ตัวอย่างการเพิ่มคอลัมน์ใหม่
            $table->text('issue_detail');
            $table->integer('inv_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('issue', function (Blueprint $table) {
            // ตัวอย่างการลบคอลัมน์ที่เพิ่มใหม่
        });
    }
};
