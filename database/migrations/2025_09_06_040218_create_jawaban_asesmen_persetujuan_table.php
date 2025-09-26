<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jawaban_asesmen_persetujuan', function (Blueprint $table) {
            $table->id('id_jawaban_persetujuan');
            $table->unsignedBigInteger('id_jawaban');
            $table->date('tgl_ttd_asesi')->nullable();
            $table->longText('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->longText('ttd_asesor')->nullable();
            $table->timestamps();

            $table->foreign('id_jawaban')->references('id_jawaban')->on('jawaban_asesmen')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jawaban_asesmen_persetujuan');
    }
};