<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asesor', function (Blueprint $table) {
            $table->id('id_asesor');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_asesor')->nullable();
            $table->string('nip')->nullable();
            $table->string('email')->nullable();
            $table->string('jabatan')->nullable();
            $table->unsignedBigInteger('id_jurusan')->nullable(); // foreign key ke jurusan
            $table->string('no_registrasi')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesor');
    }
};