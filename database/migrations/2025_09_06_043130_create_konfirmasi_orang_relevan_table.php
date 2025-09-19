<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('konfirmasi_orang_relevan', function (Blueprint $table) {
            $table->id('id_konfirmasi');
            $table->unsignedBigInteger('id_validasi');
            $table->string('nama')->nullable();
            $table->string('jabatan')->nullable();
            $table->date('tgl_konfirmasi')->nullable();
            $table->text('keterangan')->nullable();

            $table->foreign('id_validasi')->references('id_validasi')->on('validasi_asesmen')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('konfirmasi_orang_relevan');
    }
};