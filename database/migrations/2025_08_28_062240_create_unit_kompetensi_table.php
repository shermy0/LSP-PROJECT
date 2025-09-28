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
        Schema::create('unit_kompetensi', function (Blueprint $table) {
            $table->id('id_unit');
            $table->unsignedBigInteger('id_skema');
            $table->string('kode_unit');
            $table->string('judul_unit');
            $table->text('standar_kompetensi')->nullable();
            $table->text('deskripsi_unit')->nullable();
            $table->timestamps();

            // foreign key ke tabel skema_sertifikasi
            $table->foreign('id_skema')
                  ->references('id_skema')
                  ->on('skema_sertifikasi')
                  ->onDelete('cascade'); // kalau skema dihapus, unit ikut terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_kompetensi');
    }
};
