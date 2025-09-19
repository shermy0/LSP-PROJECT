<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('elemen_kompetensi', function (Blueprint $table) {
            $table->id('id_elemen');
            $table->unsignedBigInteger('id_unit');
            $table->text('nama_elemen')->nullable();

            $table->foreign('id_unit')->references('id_unit')->on('unit_kompetensi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('elemen_kompetensi');
    }
};