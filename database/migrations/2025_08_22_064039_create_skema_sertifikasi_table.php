<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('skema_sertifikasi', function (Blueprint $table) {
            $table->id('id_skema');
            $table->string('nama_skema');
            $table->string('kode_skema')->unique();
            $table->string('jenjang')->nullable(); // untuk KKNI
            $table->string('bidang_keahlian')->nullable(); // untuk Okupasi
            $table->text('deskripsi')->nullable();
            $table->enum('status_skema', ['Aktif','Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skema_sertifikasi');
    }
};