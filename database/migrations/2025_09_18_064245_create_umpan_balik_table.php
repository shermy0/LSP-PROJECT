<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('umpan_balik', function (Blueprint $table) {
            $table->id();

            // Relasi ke skema sertifikasi / asesi / asesor
            $table->unsignedBigInteger('id_skema')->nullable();
            $table->unsignedBigInteger('id_asesor')->nullable();
            $table->unsignedBigInteger('id_asesi')->nullable();

            
            // Data umum
            $table->string('nomor_skema')->nullable();
            $table->string('tempat')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();

            // Pertanyaan Ya/Tidak
            $table->boolean('penjelasan_proses')->nullable(); 
            $table->text('catatan_proses')->nullable();

            $table->boolean('kesempatan_mempelajari')->nullable();
            $table->text('catatan_mempelajari')->nullable();

            $table->boolean('diskusi_metoda')->nullable();
            $table->text('catatan_diskusi')->nullable();

            $table->boolean('menggali_bukti')->nullable();
            $table->text('catatan_bukti')->nullable();

            $table->boolean('demonstrasi_kompetensi')->nullable();
            $table->text('catatan_demonstrasi')->nullable();

            $table->boolean('penjelasan_keputusan')->nullable();
            $table->text('catatan_keputusan')->nullable();

            $table->boolean('umpan_balik')->nullable();
            $table->text('catatan_umpan_balik')->nullable();

            $table->boolean('mempelajari_dokumen')->nullable();
            $table->text('catatan_dokumen')->nullable();

            $table->boolean('jaminan_rahasia')->nullable();
            $table->text('catatan_rahasia')->nullable();

            $table->boolean('komunikasi_efektif')->nullable();
            $table->text('catatan_komunikasi')->nullable();

            // Catatan tambahan
            $table->text('catatan_lainnya')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('umpan_balik');
    }
};