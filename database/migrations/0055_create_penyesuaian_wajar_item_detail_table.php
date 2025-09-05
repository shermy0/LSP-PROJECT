<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penyesuaian_wajar_item_detail', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_item')->nullable()->constrained(table: 'penyesuaian_wajar_item', column: 'id_item') ->nullOnDelete();
            $table->text('alasan')->nullable();
            $table->text('catatan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyesuaian_wajar_item_detail');
    }
};
