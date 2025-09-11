<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->unsignedBigInteger('user_id');
            $table->string('nama_admin')->nullable();
            $table->string('nip')->nullable();
            $table->string('email')->nullable();
            $table->string('no_registrasi')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('admin');
    }
};