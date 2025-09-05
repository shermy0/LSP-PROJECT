<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('permohonan', function (Blueprint $table) {
            $table->id('id_permohonan');
            $table->foreignId('id_asesi')->nullable()->constrained(table: 'asesi', column: 'id_asesi') ->nullOnDelete();
            $table->foreignId('id_admin')->nullable()->constrained(table: 'admin', column: 'id_admin') ->nullOnDelete();
            $table->foreignId('id_skema')->nullable()->constrained(table: 'skema_sertifikasi', column: 'id_skema') ->nullOnDelete();
            $table->date('tgl_permohonan')->nullable();
            $table->enum('tujuan_asesmen', ['sertifikasi', 'sertifikasi ulang', 'lainnya' ])->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->nullable();
            $table->text('catatan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan');
    }
};
