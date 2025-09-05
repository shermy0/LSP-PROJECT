<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporan_asesmen', function (Blueprint $table) {
            $table->id('id_laporan');
            $table->foreignId('id_instrumen')->nullable()->constrained(table: 'instrumen_asesmen', column: 'id_instrumen') ->nullOnDelete();
            $table->text('aspek_positif_negatif')->nullable();
            $table->text('penolakan')->nullable();
            $table->text('saran_perbaikan')->nullable();
            $table->date('tgl_laporan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_asesmen');
    }
};
