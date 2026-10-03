<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pertanyaan_asesmen_persetujuan')
            || !Schema::hasColumn('pertanyaan_asesmen_persetujuan', 'id_pertanyaan')) {
            return;
        }

        Schema::table('pertanyaan_asesmen_persetujuan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pertanyaan')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Keep the legacy column nullable so current per-set signatures remain insertable.
    }
};
