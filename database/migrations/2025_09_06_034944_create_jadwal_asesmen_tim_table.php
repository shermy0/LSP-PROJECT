<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jadwal_asesmen_tim', function (Blueprint $table) {
            $table->id('id_tim');
            $table->unsignedBigInteger('id_jadwal');
            $table->string('nama_tim')->nullable();
            $table->text('keterangan')->nullable();

            $table->foreign('id_jadwal')->references('id_jadwal')->on('jadwal_asesmen')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jadwal_asesmen_tim');
    }
};