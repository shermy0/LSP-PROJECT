<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('konfirmasi_orang_relevan_persetujuan', function (Blueprint $table) {
            $table->id('id_konfirmasi_persetujuan');
            $table->foreignId('id_konfirmasi')->nullable()->constrained(table: 'konfirmasi_orang_relevan', column: 'id_konfirmasi') ->nullOnDelete();
            $table->string('ttd_pemberi_konfirmasi')->nullable();
            $table->date('tgl_ttd_pemberi_konfirmasi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konfirmasi_orang_relevan_persetujuan');
    }
};
