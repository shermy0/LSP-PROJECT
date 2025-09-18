<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumen_persyaratan', function (Blueprint $table) {
            $table->id('id_dokumen');
            $table->unsignedBigInteger('id_permohonan');
            $table->unsignedBigInteger('id_jenis_dokumen');
            $table->boolean('ada')->nullable();
            $table->boolean('memenuhi_syarat')->nullable();

            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan')->onDelete('cascade');
            $table->foreign('id_jenis_dokumen')->references('id_jenis_dokumen')->on('jenis_dokumen')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_persyaratan');
    }
};