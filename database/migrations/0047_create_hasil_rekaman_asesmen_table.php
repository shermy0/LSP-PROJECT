<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hasil_rekaman_asesmen', function (Blueprint $table) {
            $table->id('id_bukti');
            $table->foreignId('id_unit')->nullable()->constrained(table: 'unit_kompetensi', column: 'id_unit') ->nullOnDelete();
            $table->foreignId('id_rekaman')->nullable()->constrained(table: 'rekaman_asesmen', column: 'id_rekaman') ->nullOnDelete();      
            $table->boolean('observasi')->nullable();
            $table->boolean('pernyataan_pihak_ketiga')->nullable();
            $table->boolean('pertanyaan_wawancara')->nullable();
            $table->boolean('pertanyaan_lisan')->nullable();
            $table->boolean('pertanyaan_tertulis')->nullable();
            $table->boolean('proyek_kerja')->nullable();
            $table->boolean('lainnya')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('hasil_rekaman_asesmen');
    }
};
