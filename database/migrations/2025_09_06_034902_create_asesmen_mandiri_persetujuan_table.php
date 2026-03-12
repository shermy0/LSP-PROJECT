<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asesmen_mandiri_persetujuan', function (Blueprint $table) {
            $table->id('id_asesmen_mandiri_persetujuan');
            $table->unsignedBigInteger('id_asesmen_mandiri');
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();

            // tambahan kolom sesuai saran
            $table->enum('status_persetujuan', ['menunggu','diterima','ditolak'])->default('menunggu');
            $table->text('catatan')->nullable();

            $table->foreign('id_asesmen_mandiri')
                ->references('id_asesmen_mandiri')
                ->on('asesmen_mandiri_master')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesmen_mandiri_persetujuan');
    }
};
