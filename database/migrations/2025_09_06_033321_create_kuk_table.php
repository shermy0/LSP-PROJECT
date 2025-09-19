<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kuk', function (Blueprint $table) {
            $table->id('id_kuk');
            $table->unsignedBigInteger('id_elemen');
            $table->text('deskripsi_kuk')->nullable();

            $table->foreign('id_elemen')->references('id_elemen')->on('elemen_kompetensi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('kuk');
    }
};