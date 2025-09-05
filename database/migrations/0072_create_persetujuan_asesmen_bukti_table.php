<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('persetujuan_asesmen_bukti', function (Blueprint $table) {
            $table->id('id_bukti');
            $table->foreignId('id_persetujuan')->nullable()->constrained(table: 'persetujuan_asesmen', column: 'id_persetujuan') ->nullOnDelete();
            $table->foreignId('id_jenis_bukti')->nullable()->constrained(table: 'master_jenis_bukti', column: 'id_jenis_bukti') ->nullOnDelete();
            $table->integer('dipilih')->nullable();
            $table->text('deskripsi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persetujuan_asesmen_bukti');
    }
};
