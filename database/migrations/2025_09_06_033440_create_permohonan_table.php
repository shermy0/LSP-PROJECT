<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id('id_permohonan');
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_admin');
            $table->unsignedBigInteger('id_skema');
            $table->date('tgl_permohonan')->nullable();
            $table->enum('tujuan_asesmen', ['Sertifikasi', 'PKT', 'RPL', 'Lainnya'])->nullable();
            $table->enum('status', ['Diajukan', 'Diterima', 'Ditolak'])->nullable();
            $table->text('catatan')->nullable();

            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_admin')->on('admin')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan');
    }
};