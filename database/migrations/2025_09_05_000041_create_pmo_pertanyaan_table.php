<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pmo_pertanyaan', function (Blueprint $table) {
            $table->id('id_pmo_pertanyaan');
            $table->foreignId('id_pmo')->nullable()->constrained(table: 'pmo', column: 'id_pmo')->nullOnDelete();
            $table->foreignId('id_unit')->nullable()->constrained(table: 'unit_kompetensi', column: 'id_unit')->nullOnDelete();
            $table->string('pertanyaan')->nullable();
            $table->text('deskripsi_pertanyaan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pmo_pertanyaan');
    }
};
