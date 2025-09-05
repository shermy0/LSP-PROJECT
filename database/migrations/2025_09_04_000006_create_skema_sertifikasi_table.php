<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('skema_sertifikasi', function (Blueprint $table) {
            $table->id('id_skema');
            $table->string('kode_skema')->nullable();
            $table->string('nama_skema')->nullable();
            $table->text('deskripsi')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('skema_sertifikasi');
    }
};