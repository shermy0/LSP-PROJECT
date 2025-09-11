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
    Schema::create('perangkat_asesmen', function (Blueprint $table) {
        $table->id('id_perangkat');
        $table->unsignedBigInteger('id_unit')->nullable();
        $table->unsignedBigInteger('id_instrumen')->nullable();
        $table->unsignedBigInteger('id_jenis_bukti')->nullable();
        $table->text('catatan_penerapan')->nullable();
        $table->timestamps();

        $table->foreign('id_jenis_bukti')->references('id_jenis_bukti')->on('master_jenis_bukti')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perangkat_asesmen');
    }
};
