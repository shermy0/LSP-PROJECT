<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('demonstrasi_persetujuan', function (Blueprint $table) {
            $table->id('id_demonstrasi_persetujuan');
            $table->unsignedBigInteger('id_demonstrasi');
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();

            $table->foreign('id_demonstrasi')->references('id_demonstrasi')->on('demonstrasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('demonstrasi_persetujuan');
    }
};