<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('elemen_kompetensi', function (Blueprint $table) {
            $table->increments('id_elemen');
            $table->foreignId('id_unit')->nullable()->constrained('unit_kompetensi')->onDelete('cascade');
            $table->text('nama_elemen')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('elemen_kompetensi');
    }
};