<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('master_tugas_demonstrasi', function (Blueprint $table) {
            $table->id('id_tugas');
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_unit');
            $table->unsignedBigInteger('id_kuk');
            $table->string('nama_tugas')->nullable();
            $table->text('deskripsi_pertanyaan')->nullable();
            $table->text('instruksi')->nullable();
            $table->string('durasi')->nullable();

            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_unit')->references('id_unit')->on('unit_kompetensi')->onDelete('cascade');
            $table->foreign('id_kuk')->references('id_kuk')->on('kuk')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_tugas_demonstrasi');
    }
};