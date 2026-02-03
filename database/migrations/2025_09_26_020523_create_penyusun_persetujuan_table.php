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
        Schema::create('penyusun_persetujuan', function (Blueprint $table) {
            $table->increments('id'); // PRIMARY KEY auto increment
            $table->integer('id_asesor')->nullable();
            $table->integer('id_skema')->nullable();
            $table->string('no_met', 50)->nullable();
            $table->date('tanggal')->nullable();
            $table->longText('tanda_tangan')->nullable();
            $table->longText('catatan')->nullable();

            // timestamps opsional, kalau mau ada created_at & updated_at
            // $table->timestamps();
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