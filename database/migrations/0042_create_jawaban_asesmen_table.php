<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jawaban_asesmen', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->foreignId('id_asesi')->nullable()->constrained(table: 'asesi', column: 'id_asesi') ->nullOnDelete();
            $table->foreignId('id_hasil')->nullable()->constrained(table: 'hasil_asesmen', column: 'id_hasil') ->nullOnDelete();      
            $table->foreignId('id_unit')->nullable()->constrained(table: 'unit_kompetensi', column: 'id_unit') ->nullOnDelete();      
            $table->foreignId('id_skema')->nullable()->constrained(table: 'skema_sertifikasi', column: 'id_skema') ->nullOnDelete();      
            $table->foreignId('id_pertanyaan')->nullable()->constrained(table: 'pertanyaan', column: 'id_pertanyaan') ->nullOnDelete();      
            $table->text('jawaban_text')->nullable();
            $table->integer('jawaban_opsi')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('jawaban_asesmen');
    }
};
