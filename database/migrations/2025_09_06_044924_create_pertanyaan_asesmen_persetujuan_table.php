<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pertanyaan_asesmen_persetujuan', function (Blueprint $table) {
            $table->id('id_pertanyaan_persetujuan');
            $table->unsignedBigInteger('id_pembuatan_pertanyaan');
            $table->unsignedBigInteger('id_asesor');
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();

            $table->foreign('id_pembuatan_pertanyaan')->references('id_pembuatan_pertanyaan')->on('pembuatan_pertanyaan')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pertanyaan_asesmen_persetujuan');
    }
};