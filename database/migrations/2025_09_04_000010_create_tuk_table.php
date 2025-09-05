<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tuk', function (Blueprint $table) {
            $table->id('id_tuk');
            $table->string('nama_tuk')->nullable();
            $table->string('alamat')->nullable();
            $table->string('jenis_tuk')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('tuk');
    }
};