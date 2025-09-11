<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formulir', function (Blueprint $table) {
            $table->id();
            $table->string('skema')->nullable();
            $table->string('okupasi')->nullable();
            $table->string('nomor')->nullable();
            $table->string('tempat_uji')->nullable();
            $table->string('nama_asesi')->nullable();
            $table->string('nama_asesor')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formulir');
    }
};
