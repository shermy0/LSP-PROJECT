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
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_asesor');
            $table->unsignedBigInteger('id_asesi');
            $table->text('umpan_balik')->nullable();
            $table->enum('rekomendasi', ['Kompeten', 'Belum Kompeten'])->nullable();
            $table->text('rekomendasi_rincian')->nullable();

            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('observasi_ceklis');
    }
};