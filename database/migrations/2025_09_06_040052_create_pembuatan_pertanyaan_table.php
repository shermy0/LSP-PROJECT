<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembuatan_pertanyaan', function (Blueprint $table) {
            $table->id('id_pembuatan_pertanyaan');
            $table->unsignedBigInteger('id_skema');
            $table->string('judul'); // 🟢 Tambahan kolom judul
            $table->enum('jenis_pertanyaan', ['lisan', 'esai', 'pilihan_ganda', 'pmo']);
            $table->integer('timer')->nullable(); // Waktu menjawab per soal (dalam detik/menit)
            $table->boolean('aktif')->default(true)->comment('True = aktif, False = nonaktif');
            $table->timestamp('timescap')->useCurrent()->comment('Waktu soal dibuat');

            $table->foreign('id_skema')
                ->references('id_skema')
                ->on('skema_sertifikasi')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembuatan_pertanyaan');
    }
};
