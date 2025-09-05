<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->foreignId('user_id')->nullable()->constrained('user')->onDelete('cascade');            $table->string('nama_admin')->nullable();
            $table->string('nip')->nullable();
            $table->string('email')->nullable();
            $table->string('no_registrasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
