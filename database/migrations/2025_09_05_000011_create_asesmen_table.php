<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asesmen', function (Blueprint $table) {
            $table->id('id_asesmen');
            $table->integer('id_permohonan')->nullable();
            $table->integer('id_jadwal')->nullable();
            $table->enum('hasil', ['K', 'BK'])->nullable();
            $table->text('umpan_balik_asesi')->nullable();
            $table->text('catatan')->nullable();
            $table->date('tgl_asesmen')->nullable();
            $table->enum('status', ['proses', 'lulus'])->default('proses');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asesmen');
    }
};
