<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penyesuaian_wajar', function (Blueprint $table) {
            $table->id('id_penyesuaian');
            $table->unsignedBigInteger('id_asesmen');
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_asesor');
            $table->text('hasil_penyesuaian')->nullable();
            $table->text('acuan_pembanding')->nullable();
            $table->text('metode_asesmen')->nullable();
            $table->text('instrumen_asesmen')->nullable();

            $table->foreign('id_asesmen')->references('id_asesmen')->on('asesmen')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyesuaian_wajar');
    }
};