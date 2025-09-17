<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('unit_kompetensi', function (Blueprint $table) {
            $table->id('id_unit');
            $table->unsignedBigInteger('id_skema');
            $table->string('kode_unit')->nullable();
            $table->string('judul_unit')->nullable();
            $table->text('standar_kompetensi')->nullable();
            $table->text('deskripsi_unit')->nullable();

            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('unit_kompetensi');
    }
};