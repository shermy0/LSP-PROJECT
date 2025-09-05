<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hasil_asesmen', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor') ->nullOnDelete();      
            $table->foreignId('id_asesi')->nullable()->constrained(table: 'asesi', column: 'id_asesi') ->nullOnDelete();      
            $table->foreignId('id_unit')->nullable()->constrained(table: 'unit_kompetensi', column: 'id_unit') ->nullOnDelete();      
            $table->foreignId('id_instrumen')->nullable()->constrained(table: 'instrumen_asesmen', column: 'id_instrumen') ->nullOnDelete();      
            // $table->foreignId('id_jenis_bukti')->nullable()->constrained('jenis_bukti')->nullOnDelete();
            $table->text('catatan')->nullable();
            $table->enum('status', ['kompeten', 'belum kompeten'])->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('hasil_asesmen');
    }
};
