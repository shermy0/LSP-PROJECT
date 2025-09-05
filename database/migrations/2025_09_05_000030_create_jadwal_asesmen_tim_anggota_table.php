<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jadwal_asesmen_tim_anggota', function (Blueprint $table) {
            $table->id('id_tim_anggota');
            $table->foreignId('id_tim')->nullable()->constrained(table: 'jadwal_asesmen_tim', column: 'id_tim') ->nullOnDelete();      
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor') ->nullOnDelete();      
            $table->enum('peran', ['Ketua', 'Anggota'])->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('jadwal_asesmen_tim_anggota');
    }
};
