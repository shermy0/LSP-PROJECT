<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pertanyaan_asesmen_persetujuan', function (Blueprint $table) {
            $table->id('id_pertanyaan_persetujuan');
            $table->foreignId('id_pertanyaan')->nullable()->constrained(table: 'pertanyaan', column: 'id_pertanyaan') ->nullOnDelete();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pertanyaan_asesmen_persetujuan');
    }
};
