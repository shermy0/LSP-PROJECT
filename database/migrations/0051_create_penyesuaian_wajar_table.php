<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penyesuaian_wajar', function (Blueprint $table) {
            $table->id('id_penyesuaian');
            $table->foreignId('id_asesmen')->nullable()->constrained(table: 'asesmen', column: 'id_asesmen') ->nullOnDelete();
            $table->foreignId('id_asesi')->nullable()->constrained(table: 'asesi', column: 'id_asesi') ->nullOnDelete();
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor') ->nullOnDelete();              
            $table->text('hasil_penyesuaian')->nullable();
            $table->text('acuan_pembanding')->nullable();
            $table->text('metode_asesmen')->nullable();
            $table->text('instrumen_asesmen')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penyesuaian_wajar');
    }
};
