<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jenis_dokumen', function (Blueprint $table) {
            $table->id('id_jenis_dokumen');
            $table->string('nama_jenis')->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jenis_dokumen');
    }
};