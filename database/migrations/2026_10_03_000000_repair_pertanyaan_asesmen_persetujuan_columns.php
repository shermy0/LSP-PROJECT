<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('pertanyaan_asesmen_persetujuan')) {
            return;
        }

        Schema::table('pertanyaan_asesmen_persetujuan', function (Blueprint $table) {
            if (!Schema::hasColumn('pertanyaan_asesmen_persetujuan', 'id_pembuatan_pertanyaan')) {
                $table->unsignedBigInteger('id_pembuatan_pertanyaan')->nullable()->index();
            }
            if (!Schema::hasColumn('pertanyaan_asesmen_persetujuan', 'id_asesor')) {
                $table->unsignedBigInteger('id_asesor')->nullable()->index();
            }
        });
    }

    public function down(): void
    {
        // Keep saved assessor signatures intact during rollback.
    }
};
