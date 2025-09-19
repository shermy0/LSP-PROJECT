<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asesmen_mandiri_master', function (Blueprint $table) {
            $table->id('id_asesmen_mandiri');
            $table->unsignedBigInteger('id_permohonan');
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_asesor');
            $table->enum('rekomendasi', ['Dapat Dilanjutkan', 'Tidak Dapat Dilanjutkan'])->nullable();

            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesmen_mandiri_master');
    }
};