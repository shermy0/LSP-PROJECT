<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('jawaban_pmo', function (Blueprint $table) {
    $table->id();

    $table->unsignedBigInteger('id_pembuatan_pertanyaan');
    $table->foreign('id_pembuatan_pertanyaan')
          ->references('id_pembuatan_pertanyaan')
          ->on('pembuatan_pertanyaan')
          ->onDelete('cascade');

    $table->unsignedBigInteger('id_asesi');
    $table->foreign('id_asesi')
          ->references('id_asesi')
          ->on('asesi')
          ->onDelete('cascade');

    $table->text('jawaban')->nullable();
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('jawaban_pmo');
    }
};
