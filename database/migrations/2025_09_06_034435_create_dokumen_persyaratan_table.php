<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dokumen_persyaratan', function (Blueprint $table) {
            $table->id('id_dokumen');

            // 🔗 Relasi ke permohonan dan jenis dokumen
            $table->unsignedBigInteger('id_permohonan');
            $table->unsignedBigInteger('id_jenis_dokumen');

            // 📄 Informasi status dan bukti
            $table->string('nama_file')->nullable();      // nama file asli
            $table->string('path_file')->nullable();      // lokasi penyimpanan di storage
            $table->boolean('ada')->default(false);       // apakah dokumen disertakan
            $table->boolean('memenuhi_syarat')->default(false); // hasil verifikasi oleh admin/asesor
            $table->text('catatan')->nullable();          // opsional: keterangan dari pemeriksa

            // 🕒 Tambahkan waktu pembuatan dan pembaruan
            $table->timestamps();

            // ✅ Foreign keys
            $table->foreign('id_permohonan')
                ->references('id_permohonan')->on('permohonan')
                ->onDelete('cascade');

            $table->foreign('id_jenis_dokumen')
                ->references('id_jenis_dokumen')->on('jenis_dokumen')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dokumen_persyaratan');
    }
};
