<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('unit_kompetensi', function (Blueprint $table) {
            $table->increments('id_unit');
            $table->foreignId('id_skema')->nullable()->constrained('skema_sertifikasi')->onDelete('cascade');
            $table->string('kode_unit')->nullable();
            $table->string('judul_unit')->nullable();
            $table->text('deskripsi_unit')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('unit_kompetensi');
    }
};