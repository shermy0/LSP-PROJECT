<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skema_tujuan', function (Blueprint $table) {
            $table->id('id_skema_tujuan');
            $table->unsignedBigInteger('skema_id');
            $table->unsignedBigInteger('tujuan_id');

            $table->foreign('skema_id')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->foreign('tujuan_id')->references('id_tujuan')->on('tujuan_asesmen')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skema_tujuan');
    }
};
