<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('perangkat_asesmen', function (Blueprint $table) {
            $table->id('id_perangkat');
            $table->foreignId('id_unit')->nullable()->constrained(table: 'unit_kompetensi', column: 'id_unit') ->nullOnDelete();
            $table->foreignId('id_instrumen')->nullable()->constrained(table: 'instrumen_asesmen', column: 'id_instrumen') ->nullOnDelete();
            $table->string('jenis_bukti')->nullable();
            $table->text('catatan_penerapan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perangkat_asesmen');
    }
};
