<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kuk', function (Blueprint $table) {
            $table->id('id_kuk');
            $table->foreignId('id_elemen')->nullable()
            ->constrained(table: 'elemen_kompetensi', column: 'id_elemen')
            ->cascadeOnDelete();
                  $table->text('deskripsi_kuk')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kuk');
    }
};