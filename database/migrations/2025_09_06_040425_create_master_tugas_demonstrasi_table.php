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
            $table->unsignedBigInteger('id_demonstrasi');
            $table->string('nama_tugas')->nullable();
            $table->text('deskripsi_pertanyaan')->nullable();
            $table->timestamp('timescap')->useCurrent()->comment('Waktu soal dibuat');

            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_demonstrasi')->references('id_demonstrasi')->on('demonstrasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_tugas_demonstrasi');
    }
};