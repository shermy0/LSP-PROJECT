<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('opsi_jawaban', function (Blueprint $table) {
            $table->id('id_opsi');
            $table->unsignedBigInteger('id_pertanyaan');
            $table->string('kode_opsi', 5)->nullable();
            $table->text('isi_opsi')->nullable();
            $table->boolean('benar')->nullable();

            $table->foreign('id_pertanyaan')->references('id_pertanyaan')->on('pertanyaan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('opsi_jawaban');
    }
};