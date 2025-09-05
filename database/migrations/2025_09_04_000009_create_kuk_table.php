<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('kuk', function (Blueprint $table) {
            $table->increments('id_kuk');
            $table->foreignId('id_elemen')->nullable()->constrained('elemen_kompetensi')->onDelete('cascade');
            $table->text('deskripsi_kuk')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('kuk');
    }
};