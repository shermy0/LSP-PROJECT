<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_asesmen', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_asesor');
            $table->unsignedBigInteger('id_tuk');
            $table->date('tgl_asesmen')->nullable();
            $table->string('lokasi')->nullable();

            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_tuk')->references('id_tuk')->on('tuk')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_asesmen');
    }
};