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
            $table->unsignedBigInteger('id_demonstrasi')->nullable();
            $table->unsignedBigInteger('id_asesor');
            $table->unsignedBigInteger('id_kelompok')->nullable();
            $table->string('isi_pertanyaan_demonstrasi');
            $table->string('file_path')->nullable();
            $table->string('file_type', 50)->nullable();
            $table->string('kunci_jawaban')->nullable();

            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_kelompok')->references('id_kelompok')->on('kelompok_pekerjaan')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_demonstrasi')->references('id_demonstrasi')->on('demonstrasi')->onDelete('cascade');
        });
    }


    public function down()
    {
        Schema::dropIfExists('master_tugas_demonstrasi');
    }
};