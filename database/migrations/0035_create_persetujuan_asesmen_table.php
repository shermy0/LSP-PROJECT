<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('persetujuan_asesmen', function (Blueprint $table) {
            $table->id('id_persetujuan');
            $table->foreignId('id_permohonan')->nullable()->constrained(table: 'permohonan', column: 'id_permohonan') ->nullOnDelete();
            $table->foreignId('id_asesi')->nullable()->constrained(table: 'asesi', column: 'id_asesi') ->nullOnDelete();
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor') ->nullOnDelete();
            $table->foreignId('id_skema')->nullable()->constrained(table: 'skema_sertifikasi', column: 'id_skema') ->nullOnDelete();
            $table->foreignId('id_tuk')->nullable()->constrained(table: 'tuk', column: 'id_tuk') ->nullOnDelete();
            $table->string('hari')->nullable();
            $table->date('tgl_pelaksanaan')->nullable();
            $table->string('waktu')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('pernyataan_kerahasiaan')->nullable();
            $table->integer('setuju_asesmen')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persetujuan_asesmen');
    }
};
