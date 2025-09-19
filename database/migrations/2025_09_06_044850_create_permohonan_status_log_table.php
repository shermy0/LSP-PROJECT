<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonan_status_log', function (Blueprint $table) {
            $table->id('id_permohonan_status_log');
            $table->unsignedBigInteger('id_permohonan');
            $table->unsignedBigInteger('id_status_permohonan');
            $table->text('keterangan')->nullable();
            $table->dateTime('changed_at')->nullable();
            $table->unsignedBigInteger('changed_by');

            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan')->onDelete('cascade');
            $table->foreign('id_status_permohonan')->references('id_status_permohonan')->on('master_status_permohonan')->onDelete('cascade');
            $table->foreign('changed_by')->references('id_admin')->on('admin')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan_status_log');
    }
};