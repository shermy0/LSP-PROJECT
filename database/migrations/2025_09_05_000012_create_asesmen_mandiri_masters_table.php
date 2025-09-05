<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asesmen_mandiri_master', function (Blueprint $table) {
            $table->id('id_asesmen_mandiri');
            $table->integer('id_permohonan')->nullable();
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor') ->nullOnDelete();      
            $table->foreignId('id_asesi')->nullable()->constrained(table: 'asesi', column: 'id_asesi') ->nullOnDelete();      
            $table->enum('rekomendasi', ['Dapat Dilanjutkan', 'Tidak Dapat Dilanjutkan'])->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asesmen_mandiri_master');
    }
};
