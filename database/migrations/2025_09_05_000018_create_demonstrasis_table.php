<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('demonstrasi', function (Blueprint $table) {
            $table->id('id_demonstrasi');
            $table->foreignId('id_asesmen')->nullable()->constrained(table: 'asesmen', column: 'id_asesmen') ->nullOnDelete();      
            $table->foreignId('id_kuk')->nullable()->constrained(table: 'kuk', column: 'id_kuk') ->nullOnDelete();      
            $table->foreignId('id_tuk')->nullable()->constrained(table: 'tuk', column: 'id_tuk') ->nullOnDelete();      
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor') ->nullOnDelete();      
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('demonstrasi');
    }
};
