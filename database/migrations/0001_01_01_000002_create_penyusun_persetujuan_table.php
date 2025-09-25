<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
            Schema::create('penyusun_persetujuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asesor_id');
            $table->date('tanggal_asesmen')->nullable();
            $table->text('tanda_tangan')->nullable();
            $table->text('komentar')->nullable();
            $table->timestamps();

            $table->foreign('asesor_id')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyusun_persetujuan');
    }
};
