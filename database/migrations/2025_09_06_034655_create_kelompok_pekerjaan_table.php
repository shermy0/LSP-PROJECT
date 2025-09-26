<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelompok_pekerjaan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kelompok')->autoIncrement();
            $table->unsignedBigInteger('id_skema');
            $table->string('nama_kelompok', 255);

            // Index dan foreign key
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelompok_pekerjaan');
    }
};
