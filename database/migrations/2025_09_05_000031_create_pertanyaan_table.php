<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id('id_pertanyaan');
            $table->foreignId('id_unit')->nullable()->constrained(table: 'unit_kompetensi', column: 'id_unit') ->nullOnDelete();      
            $table->foreignId('id_skema')->nullable()->constrained(table: 'skema_sertifikasi', column: 'id_skema') ->nullOnDelete();      
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor') ->nullOnDelete();      
            $table->enum('jenis_pertanyaan', ['lisan','esai','pilihan_ganda'])->nullable();
            $table->string('isi_pertanyaan')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_type', 50)->nullable();
            $table->text('deskripsi_pertanyaan')->nullable();
            $table->string('kunci_jawaban')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pertanyaan');
    }
};
