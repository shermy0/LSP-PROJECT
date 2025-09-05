<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('master_status_asesmen', function (Blueprint $table) {
            $table->id('id_status_asesmen');
            $table->string('kode')->nullable();
            $table->string('nama_status')->nullable();
            $table->integer('urutan')->nullable();
            $table->integer('aktif')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_status_asesmen');
    }
};
