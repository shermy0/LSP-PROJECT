<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembuatan_pertanyaan', function (Blueprint $table) {
            $table->id('id_pembuatan_pertanyaan');
            $table->unsignedBigInteger('id_asesmen');
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_unit');
            $table->unsignedBigInteger('id_elemen');
            $table->unsignedBigInteger('id_kuk');
            $table->integer('timer');
            $table->timestamp('timescap')->useCurrent()->comment('Waktu soal dibuat');


            $table->foreign('id_asesmen')->references('id_asesmen')->on('asesmen')->onDelete('cascade');
            $table->foreign('id_unit')->references('id_unit')->on('unit_kompetensi')->onDelete('cascade');
            $table->foreign('id_elemen')->references('id_elemen')->on('elemen_kompetensi')->onDelete('cascade');
            $table->foreign('id_kuk')->references('id_kuk')->on('kuk')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembuatan_pertanyaan');
    }
};