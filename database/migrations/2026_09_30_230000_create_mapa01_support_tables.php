<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('mapa01_pendekatan')) {
            Schema::create('mapa01_pendekatan', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_skema')->unique();
                $table->boolean('pelatihan_standar')->default(false);
                $table->boolean('pelatihan_nonstandar')->default(false);
                $table->boolean('pengalaman_standar')->default(false);
                $table->boolean('pengalaman_nonstandar')->default(false);
                $table->boolean('otodidak')->default(false);
            });
        }

        if (!Schema::hasTable('mapa01_konteks')) {
            Schema::create('mapa01_konteks', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_skema')->unique();
                $table->text('lingkungan')->nullable();
                $table->text('peluang')->nullable();
                $table->longText('hubungan')->nullable();
                $table->longText('hubungan_rating')->nullable();
                $table->longText('pelaksana')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('mapa01_konfirmasi')) {
            Schema::create('mapa01_konfirmasi', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_skema')->unique();
                $table->boolean('konfirmasi_manajer_lsp')->default(false);
                $table->boolean('konfirmasi_master_asesor')->default(false);
                $table->boolean('konfirmasi_manajer_pelatihan')->default(false);
                $table->boolean('konfirmasi_supervisor')->default(false);
            });
        }

        if (!Schema::hasTable('mapa01_standar_industri')) {
            Schema::create('mapa01_standar_industri', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_skema')->unique();
                $table->boolean('standar_kriteria_asesmen')->default(false);
                $table->text('standar_kinerja_perusahaan')->nullable();
                $table->text('standar_spesifikasi_produk')->nullable();
                $table->text('standar_pedoman_khusus')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Preserve schema and data in databases that may already have these tables.
    }
};
