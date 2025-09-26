<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('umpan_balik_asesmen', function (Blueprint $table) {
            $table->id('id_umpan_balik');
            $table->unsignedBigInteger('id_jawaban');
            $table->unsignedBigInteger('id_asesor');
            $table->text('umpan_balik');
            $table->timestamps();
        
            $table->foreign('id_jawaban')->references('id_jawaban')->on('jawaban_asesmen')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });        
    }

    public function down()
    {
        Schema::dropIfExists('umpan_balik_asesmen)');
    }
};