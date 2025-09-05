<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('persetujuan_asesmen_persetujuan', function (Blueprint $table) {
            $table->id('id_persetujuan_ttd');
            $table->foreignId('id_persetujuan')->nullable()->constrained(table: 'persetujuan_asesmen', column: 'id_persetujuan') ->nullOnDelete();
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('persetujuan_asesmen_persetujuan');
    }
};
