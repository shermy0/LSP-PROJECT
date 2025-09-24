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
        Schema::create('kelompok_pekerjaan', function (Blueprint $table) {
            $table->id('id_kelompok'); // primary key auto increment
            $table->unsignedBigInteger('id_skema');
            $table->string('nama_kelompok', 255);

            // Foreign key ke skema_sertifikasi
            $table->foreign('id_skema')
                  ->references('id_skema')
                  ->on('skema_sertifikasi')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_pekerjaan');
    }
};
