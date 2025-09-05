<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('validasi_asesmen', function (Blueprint $table) {
            $table->id('id_validasi');
            // $table->foreignId('id_laporan')->nullable()->constrained(table: 'laporan', column: 'id_laporan')->nullOnDelete();
            $table->string('periode')->nullable();
            $table->date('tgl_validasi')->nullable();
            $table->text('tujuan')->nullable();
            $table->text('konteks')->nullable();
            $table->text('rekomendasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('validasi_asesmen');
    }
};
