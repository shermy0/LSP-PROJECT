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
    Schema::create('jawaban_pmo', function (Blueprint $table) {
        $table->id();
        // $table->foreignId('id_pembuatan_pertanyaan')->constrained('pembuatan_pertanyaan')->onDelete('cascade');
        // $table->foreignId('id_asesi')->constrained('asesi')->onDelete('cascade');
        $table->text('jawaban')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_pmo');
    }
};
