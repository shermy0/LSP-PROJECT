<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rekaman_asesmen', function (Blueprint $table) {
            $table->id('id_rekaman');
            $table->unsignedBigInteger('id_asesmen');
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_tuk');
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_asesor');
            $table->enum('hasil', ['K', 'BK'])->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->text('komentar_asesor')->nullable();

            $table->foreign('id_asesmen')->references('id_asesmen')->on('asesmen')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_tuk')->references('id_tuk')->on('tuk')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekaman_asesmen');
    }
};