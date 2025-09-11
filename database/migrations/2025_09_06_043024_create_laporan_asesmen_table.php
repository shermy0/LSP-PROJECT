<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan_asesmen', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->unsignedBigInteger('id_instrumen');
            $table->text('aspek_positif_negatif')->nullable();
            $table->text('penolakan')->nullable();
            $table->text('saran_perbaikan')->nullable();
            $table->date('tgl_laporan')->nullable();

            $table->foreign('id_instrumen')->references('id_instrumen')->on('instrumen_asesmen')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_asesmen');
    }
};