<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('validasi_asesmen', function (Blueprint $table) {
            $table->id('id_validasi');
            $table->unsignedBigInteger('id_laporan');
            $table->string('periode')->nullable();
            $table->date('tgl_validasi')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('konteks')->nullable();
            $table->text('rekomendasi')->nullable();

            $table->foreign('id_laporan')->references('id_laporan')->on('laporan_asesmen')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('validasi_asesmen');
    }
};