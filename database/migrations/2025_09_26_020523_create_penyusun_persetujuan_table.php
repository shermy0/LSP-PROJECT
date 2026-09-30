<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // The table is first created by the earlier project migration. Extend it
        // here so this migration works both on fresh installs and existing DBs.
        if (!Schema::hasTable('penyusun_persetujuan')) {
            Schema::create('penyusun_persetujuan', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedBigInteger('id_asesor')->nullable();
                $table->unsignedBigInteger('id_skema')->nullable();
                $table->string('no_met', 50)->nullable();
                $table->date('tanggal')->nullable();
                $table->longText('tanda_tangan')->nullable();
                $table->longText('catatan')->nullable();
                $table->string('role')->nullable();
                $table->string('form_type')->nullable();
            });
            return;
        }

        Schema::table('penyusun_persetujuan', function (Blueprint $table) {
            if (!Schema::hasColumn('penyusun_persetujuan', 'id_asesor')) {
                $table->unsignedBigInteger('id_asesor')->nullable();
            }
            if (!Schema::hasColumn('penyusun_persetujuan', 'id_skema')) {
                $table->unsignedBigInteger('id_skema')->nullable();
            }
            if (!Schema::hasColumn('penyusun_persetujuan', 'no_met')) {
                $table->string('no_met', 50)->nullable();
            }
            if (!Schema::hasColumn('penyusun_persetujuan', 'tanggal')) {
                $table->date('tanggal')->nullable();
            }
            if (!Schema::hasColumn('penyusun_persetujuan', 'tanda_tangan')) {
                $table->longText('tanda_tangan')->nullable();
            }
            if (!Schema::hasColumn('penyusun_persetujuan', 'catatan')) {
                $table->longText('catatan')->nullable();
            }
            if (!Schema::hasColumn('penyusun_persetujuan', 'role')) {
                $table->string('role')->nullable();
            }
            if (!Schema::hasColumn('penyusun_persetujuan', 'form_type')) {
                $table->string('form_type')->nullable();
            }
        });

        // Fields required by the legacy schema are optional in the planning UI.
        Schema::table('penyusun_persetujuan', function (Blueprint $table) {
            if (Schema::hasColumn('penyusun_persetujuan', 'asesor_id')) {
                $table->unsignedBigInteger('asesor_id')->nullable()->change();
            }
            if (Schema::hasColumn('penyusun_persetujuan', 'tanggal_asesmen')) {
                $table->date('tanggal_asesmen')->nullable()->change();
            }
            if (Schema::hasColumn('penyusun_persetujuan', 'tanggal')) {
                $table->date('tanggal')->nullable()->change();
            }
            if (Schema::hasColumn('penyusun_persetujuan', 'tanda_tangan')) {
                $table->longText('tanda_tangan')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('penyusun_persetujuan')) {
            return;
        }

        Schema::table('penyusun_persetujuan', function (Blueprint $table) {
            foreach (['id_asesor', 'id_skema', 'role', 'form_type', 'catatan'] as $column) {
                if (Schema::hasColumn('penyusun_persetujuan', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
