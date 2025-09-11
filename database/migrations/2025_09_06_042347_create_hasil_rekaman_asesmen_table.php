<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hasil_rekaman_asesmen', function (Blueprint $table) {
            $table->id('id_bukti');
            $table->unsignedBigInteger('id_rekaman');
            $table->unsignedBigInteger('id_unit');
            $table->boolean('observasi')->nullable();
            $table->boolean('pernyataan_pihak_ketiga')->nullable();
            $table->boolean('pertanyaan_wawancara')->nullable();
            $table->boolean('pertanyaan_lisan')->nullable();
            $table->boolean('pertanyaan_tertulis')->nullable();
            $table->boolean('proyek_kerja')->nullable();
            $table->boolean('lainnya')->nullable();

            $table->foreign('id_rekaman')->references('id_rekaman')->on('rekaman_asesmen')->onDelete('cascade');
            $table->foreign('id_unit')->references('id_unit')->on('unit_kompetensi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil_rekaman_asesmen');
    }
};