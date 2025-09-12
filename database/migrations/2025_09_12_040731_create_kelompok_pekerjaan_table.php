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
        Schema::create('kelompok_pekerjaan', function (Blueprint $table) {
            $table->id('id_kelompok');

            // relasi ke skema_sertifikasi
            $table->foreignId('skema_id')
                  ->constrained('skema_sertifikasi', 'id_skema')
                  ->cascadeOnDelete();

            // kolom tambahan (sesuaikan kebutuhanmu)
            $table->string('nama_kelompok');
            $table->text('deskripsi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_pekerjaan');
    }
};
