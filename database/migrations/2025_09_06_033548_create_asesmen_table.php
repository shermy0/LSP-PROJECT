<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asesmen', function (Blueprint $table) {
            $table->id('id_asesmen');
            $table->unsignedBigInteger('id_permohonan');
            $table->unsignedBigInteger('id_jadwal');
            $table->enum('hasil', ['K', 'BK'])->nullable();
            $table->text('umpan_balik_asesi')->nullable();
            $table->text('catatan')->nullable();
            $table->date('tgl_asesmen')->nullable();
            $table->enum('status', ['proses', 'lulus'])->default('proses');

            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan')->onDelete('cascade');
            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal_asesmen')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesmen');
    }
};