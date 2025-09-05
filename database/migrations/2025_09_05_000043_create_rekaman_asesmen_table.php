<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rekaman_asesmen', function (Blueprint $table) {
            $table->id('id_rekaman');
            $table->foreignId('id_asesmen')->nullable()->constrained(table: 'asesmen', column: 'id_asesmen')->nullOnDelete();
            $table->foreignId('id_skema')->nullable()->constrained(table: 'skema_sertifikasi', column: 'id_skema')->nullOnDelete();
            $table->foreignId('id_tuk')->nullable()->constrained(table: 'tuk', column: 'id_tuk')->nullOnDelete();
            $table->foreignId('id_asesi')->nullable()->constrained(table: 'asesi', column: 'id_asesi')->nullOnDelete();
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor')->nullOnDelete();
            $table->enum('hasil', ['K','BK'])->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->text('komentar_asesor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rekaman_asesmen');
    }
};
