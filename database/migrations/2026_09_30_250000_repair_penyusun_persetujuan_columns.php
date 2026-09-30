<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('penyusun_persetujuan')) {
            return;
        }

        Schema::table('penyusun_persetujuan', function (Blueprint $table) {
            if (!Schema::hasColumn('penyusun_persetujuan', 'id_asesor')) {
                $table->unsignedBigInteger('id_asesor')->nullable();
            }
            if (!Schema::hasColumn('penyusun_persetujuan', 'id_skema')) {
                $table->unsignedBigInteger('id_skema')->nullable();
            }
            if (!Schema::hasColumn('penyusun_persetujuan', 'role')) {
                $table->string('role')->nullable();
            }
            if (!Schema::hasColumn('penyusun_persetujuan', 'form_type')) {
                $table->string('form_type')->nullable();
            }
            if (!Schema::hasColumn('penyusun_persetujuan', 'catatan')) {
                $table->longText('catatan')->nullable();
            }
        });

        Schema::table('penyusun_persetujuan', function (Blueprint $table) {
            foreach (['asesor_id', 'no_met', 'tanggal', 'tanda_tangan'] as $column) {
                if (!Schema::hasColumn('penyusun_persetujuan', $column)) {
                    continue;
                }

                if ($column === 'asesor_id') {
                    $table->unsignedBigInteger($column)->nullable()->change();
                } elseif ($column === 'tanggal') {
                    $table->date($column)->nullable()->change();
                } elseif ($column === 'tanda_tangan') {
                    $table->longText($column)->nullable()->change();
                } else {
                    $table->string($column, 50)->nullable()->change();
                }
            }
        });
    }

    public function down(): void
    {
        // Keep compatibility columns and existing approval records intact.
    }
};
