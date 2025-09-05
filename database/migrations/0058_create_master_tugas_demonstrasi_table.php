<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_tugas_demonstrasi', function (Blueprint $table) {
            $table->id('id_tugas');
            $table->foreignId('id_skema')->nullable()->constrained(table: 'skema_sertifikasi', column: 'id_skema') ->nullOnDelete();
            $table->foreignId('id_unit')->nullable()->constrained(table: 'unit_kompetensi', column: 'id_unit') ->nullOnDelete();
            $table->foreignId('id_kuk')->nullable()->constrained(table: 'kuk', column: 'id_kuk') ->nullOnDelete();
            $table->string('nama_tugas')->nullable();
            $table->text('deskripsi_pertanyaan')->nullable();
            $table->text('instruksi')->nullable();
            $table->string('durasi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_tugas_demonstrasi');
    }
};
