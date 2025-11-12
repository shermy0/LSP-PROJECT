<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_asesmen_tim_anggota', function (Blueprint $table) {
            $table->id('id_tim_anggota');
            $table->unsignedBigInteger('id_tim');
            $table->unsignedBigInteger('id_asesor');
            $table->enum('peran', ['Ketua', 'Anggota'])->nullable();

            $table->foreign('id_tim')->references('id_tim')->on('jadwal_asesmen_tim')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_asesmen_tim_anggota');
    }
};