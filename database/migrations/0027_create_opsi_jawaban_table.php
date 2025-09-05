<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('opsi_jawaban', function (Blueprint $table) {
            $table->id('id_opsi');
            $table->foreignId('id_pertanyaan')->nullable()->constrained(table: 'pertanyaan', column: 'id_pertanyaan') ->nullOnDelete();
            $table->string('kode_opsi')->nullable();
            $table->text('isi_opsi')->nullable();
            $table->integer('benar')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('opsi_jawaban');
    }
};
