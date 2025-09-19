<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('demonstrasi', function (Blueprint $table) {
            $table->id('id_demonstrasi');
            $table->unsignedBigInteger('id_asesmen');
            $table->unsignedBigInteger('id_kelompok');
            $table->unsignedBigInteger('id_asesor');
            $table->text('instruksi')->nullable();
            $table->integer('timer');

            $table->foreign('id_asesmen')->references('id_asesmen')->on('asesmen')->onDelete('cascade');
            $table->foreign('id_kelompok')->references('id_kelompok')->on('kelompok_pekerjaan')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });
    }
  
    public function down()
    {
        Schema::dropIfExists('demonstrasi');
    }
};