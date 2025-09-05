<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jawaban_demonstrasi', function (Blueprint $table) {
            $table->id('id_jawaban');
            $table->foreignId('id_demonstrasi')->nullable()->constrained(table: 'demonstrasi', column: 'id_demonstrasi') ->nullOnDelete();
            $table->foreignId('id_tugas')->nullable()->constrained(table: 'master_tugas_demonstrasi', column: 'id_tugas') ->nullOnDelete();
            $table->foreignId('id_asesi')->nullable()->constrained(table: 'asesi', column: 'id_asesi') ->nullOnDelete();
            $table->string('file_jawaban')->nullable();
            $table->enum('status_hasil', ['K', 'BK'])->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_demonstrasi');
    }
};
