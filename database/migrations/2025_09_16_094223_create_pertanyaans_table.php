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
        Schema::create('pertanyaans', function (Blueprint $table) {
    $table->id();
    $table->string('judul_unit');
    $table->text('pertanyaan');
    $table->string('opsi_a')->nullable();
    $table->string('opsi_b')->nullable();
    $table->string('opsi_c')->nullable();
    $table->string('opsi_d')->nullable();
    $table->string('jawaban_benar')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaans');
    }
};
