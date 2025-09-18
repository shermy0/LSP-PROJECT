<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('perangkat_asesmen', function (Blueprint $table) {
            $table->id('id_perangkat');
            $table->unsignedBigInteger('id_unit');
            $table->unsignedBigInteger('id_instrumen');
            $table->string('jenis_bukti')->nullable();
            $table->text('catatan_penerapan')->nullable();

            $table->foreign('id_unit')->references('id_unit')->on('unit_kompetensi')->onDelete('cascade');
            $table->foreign('id_instrumen')->references('id_instrumen')->on('instrumen_asesmen')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('perangkat_asesmen');
    }
};