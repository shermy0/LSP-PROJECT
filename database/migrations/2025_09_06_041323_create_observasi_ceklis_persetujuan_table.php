<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('observasi_ceklis_persetujuan', function (Blueprint $table) {
            $table->id('id_observasi_persetujuan');
            $table->unsignedBigInteger('id_observasi');
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();

            $table->foreign('id_observasi')->references('id_observasi')->on('observasi_ceklis')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('observasi_ceklis_persetujuan');
    }
};