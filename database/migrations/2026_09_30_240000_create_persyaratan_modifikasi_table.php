<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('persyaratan_modifikasi')) {
            return;
        }

        Schema::create('persyaratan_modifikasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('skema_id')->unique();
            $table->string('karakteristik_kandidat')->nullable();
            $table->text('karakteristik_keterangan')->nullable();
            $table->string('kebutuhan_tempat_kerja')->nullable();
            $table->text('kebutuhan_keterangan')->nullable();
            $table->string('saran_pelatihan')->nullable();
            $table->text('saran_keterangan')->nullable();
            $table->string('penyesuaian_asesmen')->nullable();
            $table->text('penyesuaian_keterangan')->nullable();
            $table->string('peluang_asesmen')->nullable();
            $table->text('peluang_keterangan')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        // Preserve existing planning data on rollback.
    }
};
