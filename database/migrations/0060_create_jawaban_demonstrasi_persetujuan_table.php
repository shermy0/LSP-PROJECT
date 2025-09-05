<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jawaban_demonstrasi_persetujuan', function (Blueprint $table) {
            $table->id('id_jawaban_demonstrasi_persetujuan');
            $table->foreignId('id_jawaban')->nullable()->constrained(table: 'jawaban_demonstrasi', column: 'id_jawaban') ->nullOnDelete();
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_demonstrasi_persetujuan');
    }
};
