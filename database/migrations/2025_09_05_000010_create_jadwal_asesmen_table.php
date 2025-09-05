<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jadwal_asesmen', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_skema')->nullable()->constrained(table: 'skema_sertifikasi', column: 'id_skema') ->nullOnDelete();      
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor') ->nullOnDelete();      
            $table->foreignId('id_tuk')->nullable()->constrained(table: 'tuk', column: 'id_tuk') ->nullOnDelete();      
            $table->date('tgl_asesmen')->nullable();
            $table->string('lokasi')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('jadwal_asesmen');
    }
};
