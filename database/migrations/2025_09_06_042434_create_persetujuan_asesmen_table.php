<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('persetujuan_asesmen', function (Blueprint $table) {
            $table->id('id_persetujuan');
            $table->unsignedBigInteger('id_permohonan');
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_asesor');
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_tuk');
            $table->string('hari')->nullable();
            $table->date('tgl_pelaksanaan')->nullable();
            $table->time('waktu')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('pernyataan_kerahasiaan')->nullable();
            $table->boolean('setuju_asesmen')->nullable();

            // Status dalam Bahasa Indonesia
            $table->enum('status', ['draf', 'menunggu_asesor', 'selesai'])->default('draf');
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('id_tuk')->references('id_tuk')->on('tuk')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('persetujuan_asesmen');
    }
};