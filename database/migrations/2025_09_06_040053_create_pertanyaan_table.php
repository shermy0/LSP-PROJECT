<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id('id_pertanyaan');
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_pembuatan_pertanyaan')->nullable();
            $table->unsignedBigInteger('id_asesor');
            $table->unsignedBigInteger('id_kelompok')->nullable();
            $table->enum('jenis_pertanyaan', ['lisan', 'esai', 'pilihan_ganda']);
            $table->string('isi_pertanyaan');
            $table->string('file_path')->nullable();
            $table->string('file_type', 50)->nullable();
            $table->text('deskripsi_pertanyaan')->nullable();
            $table->string('kunci_jawaban')->nullable();

            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_kelompok')->references('id_kelompok')->on('kelompok_pekerjaan')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_pembuatan_pertanyaan')->references('id_pembuatan_pertanyaan')->on('pembuatan_pertanyaan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pertanyaan');
    }
};