<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('inv_type');
            $table->unsignedBigInteger('inv_brand');
            $table->string('inv_model')->nullable();
            $table->text('inv_detail')->nullable();
            $table->string('inv_rtaf_serial')->nullable();
            $table->string('inv_serial_number')->nullable();
            $table->string('inv_mac_address')->nullable();
            $table->string('inv_cpu')->nullable();
            $table->string('inv_ram')->nullable();
            $table->integer('inv_ram_speed')->nullable();
            $table->string('inv_storage_type')->nullable();
            $table->integer('inv_storage_size')->nullable();
            $table->string('inv_os_type')->nullable();
            $table->string('inv_os_version')->nullable();
            $table->integer('inv_os_copyright')->nullable();
            $table->string('inv_name')->nullable();
            $table->string('inv_msoffice_version')->nullable();
            $table->integer('inv_msoffice_copyright')->nullable();
            $table->string('inv_antivirus')->nullable();
            $table->integer('inv_antivirus_copyright')->nullable();
            $table->date('inv_setup_year')->nullable();
            $table->integer('inv_status')->nullable();
            $table->string('inv_picture')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory');
    }
};
