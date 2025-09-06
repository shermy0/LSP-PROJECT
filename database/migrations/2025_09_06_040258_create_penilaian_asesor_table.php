<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penilaian_asesor', function (Blueprint $table) {
            $table->id('id_penilaian');
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_asesmen');
            $table->unsignedBigInteger('id_pertanyaan');
            $table->unsignedBigInteger('id_asesor');
            $table->unsignedBigInteger('id_jawaban');
            $table->text('pencapaian')->nullable();

            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesmen')->references('id_asesmen')->on('asesmen')->onDelete('cascade');
            $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('pertanyaan')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_jawaban')->references('id_jawaban')->on('jawaban_asesmen')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaian_asesor');
    }
};