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
        Schema::create('laporan_asesmen', function (Blueprint $table) {
            $table->id('id_laporan'); // PRIMARY KEY
            $table->unsignedBigInteger('id_instrumen')->nullable(); // ganti unsignedBigInteger
            $table->text('aspek_positif_negatif')->nullable();
            $table->text('penolakan')->nullable();
            $table->text('saran_perbaikan')->nullable();
            $table->date('tgl_laporan')->nullable();
            $table->bigInteger('asesor_id')->nullable();
            $table->bigInteger('skema_id')->nullable();
            $table->string('no_registrasi', 50)->nullable();

            // Index
            $table->index('id_instrumen');

            // Foreign key
            $table->foreign('id_instrumen')
                  ->references('id_instrumen')
                  ->on('instrumen_asesmen')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_asesmen', function (Blueprint $table) {
            $table->dropForeign(['id_instrumen']);
            $table->dropIndex(['id_instrumen']);
        });

        Schema::dropIfExists('laporan_asesmen');
    }
};