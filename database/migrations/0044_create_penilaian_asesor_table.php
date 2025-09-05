<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penilaian_asesor', function (Blueprint $table) {
            $table->id('id_penilaian');
            $table->foreignId('id_jawaban')->nullable()->constrained(table: 'jawaban_asesmen', column: 'id_jawaban') ->nullOnDelete();
            $table->foreignId('id_asesi')->nullable()->constrained(table: 'asesi', column: 'id_asesi') ->nullOnDelete();
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor') ->nullOnDelete();
            $table->foreignId('id_pertanyaan')->nullable()->constrained(table: 'pertanyaan', column: 'id_pertanyaan') ->nullOnDelete();
            $table->foreignId('id_asesmen')->nullable()->constrained(table: 'asesmen', column: 'id_asesmen') ->nullOnDelete();
            $table->text('pencapaian')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian_asesor');
    }
};
