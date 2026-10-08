<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asesor_skema', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_asesor');
            $table->unsignedBigInteger('id_skema');
            $table->timestamps(); // optional

            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_skema')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
            $table->unique(['id_asesor', 'id_skema']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesor_skema');
    }
};