<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('konfirmasi_orang_relevan', function (Blueprint $table) {
            $table->id('id_konfirmasi');
            $table->foreignId('id_validasi')->nullable()->constrained(table: 'validasi_asesmen', column: 'id_validasi') ->nullOnDelete();
            $table->string('nama')->nullable();
            $table->string('jabatan')->nullable();
            $table->date('tgl_konfirmasi')->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konfirmasi_orang_relevan');
    }
};
