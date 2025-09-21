<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jawaban_demonstrasi_persetujuan', function (Blueprint $table) {
            $table->id('id_jawaban_demonstrasi_persetujuan');
            $table->unsignedBigInteger('id_jawaban');
            $table->unsignedBigInteger('id_asesor');
            $table->unsignedBigInteger('id_asesi');
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();

            $table->foreign('id_jawaban')->references('id_jawaban')->on('jawaban_demonstrasi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('jawaban_demonstrasi_persetujuan');
    }
};