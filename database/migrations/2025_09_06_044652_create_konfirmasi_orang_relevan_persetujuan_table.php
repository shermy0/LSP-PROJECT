<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('konfirmasi_orang_relevan_persetujuan', function (Blueprint $table) {
            $table->id('id_konfirmasi_persetujuan');
            $table->unsignedBigInteger('id_konfirmasi');
            $table->string('ttd_pemberi_konfirmasi')->nullable();
            $table->date('tgl_ttd_pemberi_konfirmasi')->nullable();

            $table->foreign('id_konfirmasi')->references('id_konfirmasi')->on('konfirmasi_orang_relevan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('konfirmasi_orang_relevan_persetujuan');
    }
};