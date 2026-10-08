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
        Schema::create('banding_asesmen', function (Blueprint $table) {
            $table->id('id_banding');
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_permohonan')->nullable();
            $table->unsignedBigInteger('id_skema')->nullable();
            $table->date('tgl_asesmen')->nullable();
            $table->string('banding_dijelaskan', 10)->nullable()->comment('Ya/Tidak');
            $table->string('diskusi_dengan_asesor', 10)->nullable()->comment('Ya/Tidak');
            $table->string('libatkan_orang_lain', 10)->nullable()->comment('Ya/Tidak');
            $table->text('alasan_banding')->nullable();
            $table->date('tgl_banding')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan')->onDelete('set null');
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banding_asesmen');
    }
};