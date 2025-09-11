<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('observasi_ceklis', function (Blueprint $table) {
            $table->id('id_observasi');
            $table->unsignedBigInteger('id_asesmen');
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_tuk');
            $table->unsignedBigInteger('id_kuk');
            $table->unsignedBigInteger('id_asesor');
            $table->unsignedBigInteger('id_asesi');
            $table->text('umpan_balik')->nullable();
            $table->enum('rekomendasi', ['Kompeten', 'Belum Kompeten'])->nullable();
            $table->text('rekomendasi_rincian')->nullable();

            $table->foreign('id_asesmen')->references('id_asesmen')->on('asesmen')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_tuk')->references('id_tuk')->on('tuk')->onDelete('cascade');
            $table->foreign('id_kuk')->references('id_kuk')->on('kuk')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('observasi_ceklis');
    }
};