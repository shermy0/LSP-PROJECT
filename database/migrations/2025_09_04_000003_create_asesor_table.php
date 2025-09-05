<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('asesor', function (Blueprint $table) {
            $table->increments('id_asesor');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('nama_asesor')->nullable();
            $table->string('nip')->nullable();
            $table->string('email')->nullable();
            $table->string('keahlian')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('no_registrasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('asesor');
    }
};