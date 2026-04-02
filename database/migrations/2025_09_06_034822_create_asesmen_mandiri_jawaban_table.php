<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asesmen_mandiri_jawaban', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->unsignedBigInteger('id_asesmen_mandiri');
            $table->unsignedBigInteger('id_kuk');
            $table->enum('status', ['K', 'BK'])->nullable();
            $table->unsignedBigInteger('id_dokumen')->nullable();
            $table->string('file_lain')->nullable(); // tanpa 'after'
            $table->timestamps();

            $table->foreign('id_asesmen_mandiri')->references('id_asesmen_mandiri')->on('asesmen_mandiri_master')->onDelete('cascade');
            $table->foreign('id_kuk')->references('id_kuk')->on('kuk')->onDelete('cascade');
            $table->foreign('id_dokumen')->references('id_dokumen')->on('dokumen_persyaratan')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesmen_mandiri_jawaban');
    }
};