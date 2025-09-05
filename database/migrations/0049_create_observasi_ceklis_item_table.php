<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('observasi_ceklis_item', function (Blueprint $table) {
            $table->id('id_observasi_item');
            $table->foreignId('id_observasi')->nullable()->constrained(table: 'observasi_ceklis', column: 'id_observasi') ->nullOnDelete();
            $table->foreignId('id_unit')->nullable()->constrained(table: 'unit_kompetensi', column: 'id_unit') ->nullOnDelete();      
            $table->foreignId('id_kuk')->nullable()->constrained(table: 'kuk', column: 'id_kuk') ->nullOnDelete();              
            $table->foreignId('id_elemen')->nullable()->constrained(table: 'elemen_kompetensi', column: 'id_elemen') ->nullOnDelete();              
            $table->text('standar_industri')->nullable();
            $table->enum('pencapaian', ['K', 'BK'])->nullable();
            $table->text('penilaian_lanjut')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observasi_ceklis_item');
    }
};
