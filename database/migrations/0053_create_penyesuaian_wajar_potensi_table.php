<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penyesuaian_wajar_potensi', function (Blueprint $table) {
            $table->id('id_potensi');
            $table->foreignId('id_penyesuaian')->nullable()->constrained(table: 'penyesuaian_wajar', column: 'id_penyesuaian') ->nullOnDelete();
            $table->string('potensi')->nullable();
            $table->integer('dipilih')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyesuaian_wajar_potensi');
    }
};
