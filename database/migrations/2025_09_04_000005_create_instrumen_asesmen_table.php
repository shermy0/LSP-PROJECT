<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('instrumen_asesmen', function (Blueprint $table) {
            $table->id('id_instrumen');
            $table->string('nama_instrumen')->nullable();
            $table->string('kode_instrumen')->nullable();
            $table->string('jenis_instrumen')->nullable();
            $table->text('deskripsi')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('instrumen_asesmen');
    }
};