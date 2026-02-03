<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('observasi_ceklis_item', function (Blueprint $table) {
            $table->id('id_observasi_item');
            $table->unsignedBigInteger('id_observasi');
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_kelompok')->nullable();
            $table->unsignedBigInteger('id_unit');
            $table->unsignedBigInteger('id_elemen');
            $table->unsignedBigInteger('id_kuk');
            $table->text('standar_industri')->nullable();
            $table->enum('pencapaian', ['Ya', 'Tidak'])->nullable();
            $table->text('penilaian_lanjut')->nullable();

            $table->foreign('id_observasi')->references('id_observasi')->on('observasi_ceklis')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_kelompok')->references('id_kelompok')->on('kelompok_pekerjaan')->onDelete('cascade');
            $table->foreign('id_unit')->references('id_unit')->on('unit_kompetensi')->onDelete('cascade');
            $table->foreign('id_elemen')->references('id_elemen')->on('elemen_kompetensi')->onDelete('cascade');
            $table->foreign('id_kuk')->references('id_kuk')->on('kuk')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('observasi_ceklis_item');
    }
};