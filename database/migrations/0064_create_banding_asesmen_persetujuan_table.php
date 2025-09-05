<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banding_asesmen_persetujuan', function (Blueprint $table) {
            $table->id('id_banding_persetujuan');
            $table->foreignId('id_banding')->nullable()->constrained(table: 'banding_asesmen', column: 'id_banding') ->nullOnDelete();
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banding_asesmen_persetujuan');
    }
};
