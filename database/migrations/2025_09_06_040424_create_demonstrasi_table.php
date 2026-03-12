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
            $table->unsignedBigInteger('id_skema');
            $table->integer('timer');
            $table->timestamp('timescap')->useCurrent()->comment('Waktu soal dibuat');
            
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
        });
    }
  
    public function down()
    {
        Schema::dropIfExists('demonstrasi');
    }
};