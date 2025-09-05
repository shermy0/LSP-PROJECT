<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asesmen_mandiri_persetujuan', function (Blueprint $table) {
            $table->id('id_asesmen_mandiri_persetujuan');
            $table->foreignId('id_asesmen_mandiri')->nullable()->constrained(table: 'asesmen_mandiri_master', column: 'id_asesmen_mandiri') ->nullOnDelete();      
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asesmen_mandiri_persetujuan');
    }
};
