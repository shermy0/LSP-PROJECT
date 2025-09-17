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
            $table->unsignedBigInteger('id_unit');
            $table->string('pertanyaan')->nullable();
            $table->text('deskripsi_pertanyaan')->nullable();

            $table->foreign('id_pmo')->references('id_pmo')->on('pmo')->onDelete('cascade');
            $table->foreign('id_unit')->references('id_unit')->on('unit_kompetensi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pmo_pertanyaan');
    }
};