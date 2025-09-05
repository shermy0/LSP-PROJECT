<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penyesuaian_wajar_item', function (Blueprint $table) {
            $table->id('id_item');
            $table->foreignId('id_penyesuaian')->nullable()->constrained(table: 'penyesuaian_wajar', column: 'id_penyesuaian') ->nullOnDelete();
            $table->text('jenis_modifikasi')->nullable();
            $table->text('dipilih')->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyesuaian_wajar_item');
    }
};
