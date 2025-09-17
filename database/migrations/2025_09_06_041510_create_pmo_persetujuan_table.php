<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pmo_persetujuan', function (Blueprint $table) {
            $table->id('id_pmo_persetujuan');
            $table->unsignedBigInteger('id_pmo');
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();

            $table->foreign('id_pmo')->references('id_pmo')->on('pmo')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pmo_persetujuan');
    }
};