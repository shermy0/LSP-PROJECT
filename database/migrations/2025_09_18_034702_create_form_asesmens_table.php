<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('form_asesmens', function (Blueprint $table) {
        $table->id();
        $table->string('no_form');
        $table->string('judul_skema')->nullable();
        $table->string('nama_asesor')->nullable();
        $table->string('nama_asesi')->nullable();
        $table->date('tanggal_asesmen')->nullable();
        $table->string('tuk')->nullable();
        $table->text('umpan_balik')->nullable();
        $table->text('tanda_tangan_asesi')->nullable();
        $table->text('tanda_tangan_asesor')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_asesmens');
    }
};
