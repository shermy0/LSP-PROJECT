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
            $table->unsignedBigInteger('asesor_id');
            $table->unsignedBigInteger('skema_id');
            $table->timestamps();

            $table->foreign('asesor_id')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('skema_id')->references('id_skema')->on('skema_sertifikasi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesor_skema');
    }
};