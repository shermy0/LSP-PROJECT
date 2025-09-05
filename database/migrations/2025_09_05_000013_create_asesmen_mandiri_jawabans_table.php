<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asesmen_mandiri_jawaban', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->foreignId('id_asesmen_mandiri')->nullable()->constrained(table: 'asesmen_mandiri_master', column: 'id_asesmen_mandiri') ->nullOnDelete();      
            $table->foreignId('id_kuk')->nullable()->constrained(table: 'kuk', column: 'id_kuk') ->nullOnDelete();      
            $table->enum('status', ['K', 'BK'])->nullable();
            $table->integer('id_dokumen')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asesmen_mandiri_jawaban');
    }
};
