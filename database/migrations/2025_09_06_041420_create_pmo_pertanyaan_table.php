<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pmo_pertanyaan', function (Blueprint $table) {
            $table->id('id_pmo_pertanyaan');
            $table->unsignedBigInteger('id_pmo');
            $table->unsignedBigInteger('id_pembuatan_pertanyaan')->nullable();
            $table->unsignedBigInteger('id_kelompok')->nullable();
            $table->text('id_unit')->nullable(); // ✅ ganti jadi text, simpan JSON
            $table->string('pertanyaan')->nullable();
            $table->text('deskripsi_pertanyaan')->nullable();

            $table->foreign('id_pmo')->references('id_pmo')->on('pmo')->onDelete('cascade');
            $table->foreign('id_pembuatan_pertanyaan')->references('id_pembuatan_pertanyaan')->on('pembuatan_pertanyaan')->onDelete('cascade');
            $table->foreign('id_kelompok')->references('id_kelompok')->on('kelompok_pekerjaan')->onDelete('cascade');
            // ❌ hapus foreign key id_unit karena sekarang JSON
        });
    }

    public function down()
    {
        Schema::dropIfExists('pmo_pertanyaan');
    }
};