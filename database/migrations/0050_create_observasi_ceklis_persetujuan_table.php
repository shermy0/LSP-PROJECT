<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('observasi_ceklis_persetujuan', function (Blueprint $table) {
            $table->id('id_observasi_persetujuan');
            $table->foreignId('id_observasi')->nullable()->constrained(table: 'observasi_ceklis', column: 'id_observasi') ->nullOnDelete();
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observasi_ceklis_persetujuan');
    }
};
