<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penyesuaian_wajar_persetujuan', function (Blueprint $table) {
            $table->id('id_penyesuaian_persetujuan');
            $table->foreignId('id_penyesuaian')->nullable()->constrained(table: 'penyesuaian_wajar', column: 'id_penyesuaian') ->nullOnDelete();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyesuaian_wajar_persetujuan');
    }
};
