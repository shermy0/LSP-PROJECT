<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('master_status_permohonan', function (Blueprint $table) {
            $table->id('id_status_permohonan');
            $table->string('kode')->nullable();
            $table->string('nama_status')->nullable();
            $table->integer('urutan')->nullable();
            $table->boolean('aktif')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_status_permohonan');
    }
};