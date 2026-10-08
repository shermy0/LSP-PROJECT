<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_dokumen', function (Blueprint $table) {
            $table->id('id_jenis_dokumen');

            // 🧾 Informasi dasar dokumen
            $table->string('nama_dokumen', 150);
            $table->text('keterangan')->nullable();

            // 📂 Kategori dokumen (sesuai FR.APL.01)
            $table->enum('kategori', ['dasar', 'administratif'])->default('dasar')
                ->comment('dasar = Bukti Persyaratan Dasar Pemohon, administratif = Bukti Administratif');

            // 📎 Penanda dokumen wajib / opsional
            $table->boolean('wajib')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_dokumen');
    }
};
