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
        Schema::create('asesor', function (Blueprint $table) {
            $table->id('id_asesor');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_asesor');
            $table->string('nip')->nullable();
            $table->string('keahlian')->nullable();
            $table->string('tanda_tangan')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('no_registrasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesor');
    }
};
