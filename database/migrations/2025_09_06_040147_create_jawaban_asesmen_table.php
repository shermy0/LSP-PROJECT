<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jawaban_asesmen', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_pertanyaan');
            $table->text('jawaban_text')->nullable();
            $table->unsignedBigInteger('jawaban_opsi')->nullable();
            $table->text('pencapaian')->nullable();

            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('pertanyaan')->onDelete('cascade');
            $table->foreign('jawaban_opsi')->references('id_opsi')->on('opsi_jawaban')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jawaban_asesmen');
    }
};