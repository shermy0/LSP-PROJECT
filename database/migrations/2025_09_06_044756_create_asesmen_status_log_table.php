<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asesmen_status_log', function (Blueprint $table) {
            $table->id('id_asesmen_status_log');
            $table->unsignedBigInteger('id_asesmen');
            $table->unsignedBigInteger('id_status_asesmen');
            $table->text('keterangan')->nullable();
            $table->dateTime('changed_at')->nullable();
            $table->unsignedBigInteger('changed_by');

            $table->foreign('id_asesmen')->references('id_asesmen')->on('asesmen')->onDelete('cascade');
            $table->foreign('id_status_asesmen')->references('id_status_asesmen')->on('master_status_asesmen')->onDelete('cascade');
            $table->foreign('changed_by')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesmen_status_log');
    }
};