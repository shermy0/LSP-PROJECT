<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jawaban_demonstrasi', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_tugas');
            $table->text('jawaban_text')->nullable();
            $table->unsignedBigInteger('jawaban_file')->nullable();
            $table->text('pencapaian')->nullable();

            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_tugas')->references('id_tugas')->on('master_tugas_demonstrasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jawaban_demonstrasi');
    }
};