<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pmo_tanggapan', function (Blueprint $table) {
            $table->id('id_pmo_tanggapan');
            $table->foreignId('id_pmo')->nullable()->constrained(table: 'pmo', column: 'id_pmo')->nullOnDelete();
            $table->foreignId('id_pmo_pertanyaan')->nullable()->constrained(table: 'pmo_pertanyaan', column: 'id_pmo_pertanyaan')->nullOnDelete();
            $table->foreignId('id_unit')->nullable()->constrained(table: 'unit_kompetensi', column: 'id_unit')->nullOnDelete();
            $table->text('tanggapan')->nullable();
            $table->enum('pencapaian', ['Ya','Tidak'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pmo_tanggapan');
    }
};
