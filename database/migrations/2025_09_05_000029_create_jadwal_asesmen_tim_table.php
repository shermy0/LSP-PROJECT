<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jadwal_asesmen_tim', function (Blueprint $table) {
            $table->id('id_tim');
            $table->foreignId('id_jadwal')->nullable()->constrained(table: 'jadwal_asesmen', column: 'id_jadwal') ->nullOnDelete();      
            $table->string('nama_tim')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('jadwal_asesmen_tim');
    }
};
