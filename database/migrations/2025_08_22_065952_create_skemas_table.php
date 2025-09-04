<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skema_sertifikasi', function (Blueprint $table) {
            $table->id('id_skema');
            $table->string('nama_skema', 255);
            $table->string('kode_skema', 100)->nullable();
            $table->string('jenjang', 100)->nullable();
            $table->string('bidang_keahlian', 150)->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status_skema', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skemas');
    }
};
