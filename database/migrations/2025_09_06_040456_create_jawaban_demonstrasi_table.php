<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jawaban_demonstrasi', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_demonstrasi');
            $table->unsignedBigInteger('id_tugas');
            $table->unsignedBigInteger('id_asesi');
            $table->string('file_jawaban')->nullable();
            $table->enum('status_hasil', ['Kompeten', 'Belum Kompeten'])->nullable();

            $table->foreign('id_demonstrasi')->references('id_demonstrasi')->on('demonstrasi')->onDelete('cascade');
            $table->foreign('id_tugas')->references('id_tugas')->on('master_tugas_demonstrasi')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('jawaban_demonstrasi');
    }
};