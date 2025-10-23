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
    Schema::create('hasil_asesmen_perangkat', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('id_hasil');
        $table->unsignedBigInteger('id_perangkat');
        $table->timestamps();

        $table->foreign('id_hasil')->references('id_hasil')->on('hasil_asesmen')->onDelete('cascade');
        $table->foreign('id_perangkat')->references('id_perangkat')->on('perangkat_asesmen')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_asesmen_perangkat');
    }
};
