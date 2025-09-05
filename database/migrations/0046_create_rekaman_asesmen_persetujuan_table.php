<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rekaman_asesmen_persetujuan', function (Blueprint $table) {
            $table->id('id_rekaman_persetujuan');
            $table->foreignId('id_rekaman')->nullable()->constrained(table: 'rekaman_asesmen', column: 'id_rekaman') ->nullOnDelete();
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('rekaman_asesmen_persetujuan');
    }
};
