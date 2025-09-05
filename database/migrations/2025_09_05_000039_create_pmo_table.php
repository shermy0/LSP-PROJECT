<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pmo', function (Blueprint $table) {
            $table->id('id_pmo');
            $table->foreignId('id_asesmen')->nullable()->constrained(table: 'asesmen', column: 'id_asesmen')->nullOnDelete();
            $table->foreignId('id_skema')->nullable()->constrained(table: 'skema_sertifikasi', column: 'id_skema')->nullOnDelete();
            $table->foreignId('id_tuk')->nullable()->constrained(table: 'tuk', column: 'id_tuk')->nullOnDelete();
            $table->foreignId('id_kuk')->nullable()->constrained(table: 'kuk', column: 'id_kuk')->nullOnDelete();
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor')->nullOnDelete();
            $table->foreignId('id_asesi')->nullable()->constrained(table: 'asesi', column: 'id_asesi')->nullOnDelete();
            $table->text('umpan_balik_untuk_asesi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pmo');
    }
};
