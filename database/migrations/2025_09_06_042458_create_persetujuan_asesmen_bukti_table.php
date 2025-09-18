<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('persetujuan_asesmen_bukti', function (Blueprint $table) {
            $table->id('id_bukti');
            $table->unsignedBigInteger('id_persetujuan');
            $table->unsignedBigInteger('id_jenis_bukti');
            $table->boolean('dipilih')->nullable();
            $table->text('deskripsi')->nullable();

            $table->foreign('id_persetujuan')->references('id_persetujuan')->on('persetujuan_asesmen')->onDelete('cascade');
            $table->foreign('id_jenis_bukti')->references('id_jenis_bukti')->on('master_jenis_bukti')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('persetujuan_asesmen_bukti');
    }
};