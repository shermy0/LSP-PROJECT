<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('demonstrasi_persetujuan', function (Blueprint $table) {
            $table->id('id_demonstrasi_persetujuan');
            $table->foreignId('id_demonstrasi')->nullable()->constrained(table: 'demonstrasi', column: 'id_demonstrasi') ->nullOnDelete();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demonstrasi_persetujuan');
    }
};
