<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('proses_validasi')) {
            Schema::create('proses_validasi', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('skema_id');
                $table->string('periode', 20);
                $table->text('tujuan')->nullable();
                $table->text('tujuan_lain')->nullable();
                $table->text('konteks')->nullable();
                $table->text('konteks_lain')->nullable();
                $table->text('pendekatan')->nullable();
                $table->text('pendekatan_lain')->nullable();
                $table->timestamps();
                $table->unique(['skema_id', 'periode']);
            });
        }

        if (!Schema::hasTable('diskusi')) {
            Schema::create('diskusi', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('skema_id');
                $table->unsignedBigInteger('id_validasi')->nullable();
                $table->text('nama_asesor')->nullable();
                $table->string('jabatan', 150)->nullable();
                $table->text('hasil_diskusi')->nullable();
                $table->index(['skema_id', 'id_validasi']);
            });
        }

        if (!Schema::hasTable('acuan_pembanding')) {
            Schema::create('acuan_pembanding', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_validasi')->nullable();
                $table->unsignedBigInteger('skema_id');
                $table->text('acuan')->nullable();
                $table->text('dokumen')->nullable();
                $table->text('acuan_lain')->nullable();
                $table->text('pembanding_lain')->nullable();
                $table->text('dokumen_lain')->nullable();
                $table->text('dokumen_lain2')->nullable();
                $table->text('dokumen_lain3')->nullable();
                $table->text('dokumen_lain4')->nullable();
                $table->timestamps();
                $table->index(['skema_id', 'id_validasi']);
            });
        }

        if (!Schema::hasTable('hasil_validasi')) {
            Schema::create('hasil_validasi', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('id_validasi')->nullable();
                $table->unsignedBigInteger('skema_id');
                $table->unsignedBigInteger('user_id')->nullable();
                $table->string('keterangan')->nullable();
                $table->text('keterampilan')->nullable();
                $table->string('aspek')->nullable();
                $table->text('aturan_bukti')->nullable();
                $table->text('prinsip_asesmen')->nullable();
                $table->index(['skema_id', 'id_validasi']);
            });
        }

        if (!Schema::hasTable('kontribusi')) {
            Schema::create('kontribusi', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('skema_id');
                $table->unsignedBigInteger('id_validasi')->nullable();
                $table->text('temuan');
                $table->text('rekomendasi')->nullable();
                $table->index(['skema_id', 'id_validasi']);
            });
        }

        if (!Schema::hasTable('rencana_perbaikan')) {
            Schema::create('rencana_perbaikan', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('skema_id');
                $table->unsignedBigInteger('id_validasi')->nullable();
                $table->text('kegiatan_perbaikan')->nullable();
                $table->string('waktu_penyelesaian')->nullable();
                $table->string('penanggung_jawab')->nullable();
                $table->longText('ttd')->nullable();
                $table->index(['skema_id', 'id_validasi']);
            });
        }

        if (!Schema::hasTable('validasi_validator')) {
            Schema::create('validasi_validator', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('skema_id');
                $table->unsignedBigInteger('id_validasi')->nullable();
                $table->string('nama_validator');
                $table->string('no_registrasi')->nullable();
                $table->date('tanggal')->nullable();
                $table->longText('ttd')->nullable();
                $table->index(['skema_id', 'id_validasi']);
            });
        }

        if (!Schema::hasTable('fr_va')) {
            Schema::create('fr_va', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('skema_id');
                $table->string('nama', 100);
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('fr_va_asesor')) {
            Schema::create('fr_va_asesor', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('fr_va_id');
                $table->string('nama_asesor', 100);
                $table->string('jabatan', 100)->nullable();
                $table->timestamps();
                $table->index('fr_va_id');
            });
        }
    }

    public function down(): void
    {
        // This migration may only add the missing tables in an existing database.
        // Keep data intact when rolling back application code.
    }
};
