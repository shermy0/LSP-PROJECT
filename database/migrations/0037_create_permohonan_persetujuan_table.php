<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('permohonan_persetujuan', function (Blueprint $table) {
            $table->id('id_permohonan_persetujuan');
            $table->foreignId('id_permohonan')->nullable()->constrained(table: 'permohonan', column: 'id_permohonan') ->nullOnDelete();
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_admin')->nullable();
            $table->string('ttd_admin')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_persetujuan');
    }
};
