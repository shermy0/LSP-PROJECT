<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hasil_unit_kompetensi', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->foreignId('id_hasil_asesmen')->nullable()->constrained(table: 'hasil_asesmen', column: 'id_hasil') ->nullOnDelete();      
            $table->foreignId('id_unit')->nullable()->constrained(table: 'unit_kompetensi', column: 'id_unit') ->nullOnDelete();      
            $table->enum('hasil', ['K', 'BK'])->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('hasil_unit_kompetensi');
    }
};
