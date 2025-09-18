<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('skema_sertifikasi', function (Blueprint $table) {
            $table->id('id_skema');
            $table->string('nama_skema')->nullable();
            $table->string('kode_skema')->nullable();
            $table->string('judul_skema')->nullable();
            $table->string('jenjang')->nullable();
            $table->string('bidang_keahlian')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status_skema', ['Aktif', 'Nonaktif'])->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skema_sertifikasi');
    }
};