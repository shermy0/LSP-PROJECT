<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dokumen_persyaratan', function (Blueprint $table) {
            $table->id('id_dokumen');
            // $table->foreignId('id_permohonan')->nullable()->constrained('permohonan')->nullOnDelete();
            $table->foreignId('id_jenis_dokumen')->nullable()->constrained(table: 'jenis_dokumen', column: 'id_jenis_dokumen') ->nullOnDelete();      
            $table->boolean('ada')->nullable();
            $table->boolean('memenuhi_syarat')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('dokumen_persyaratan');
    }
};
