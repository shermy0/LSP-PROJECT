<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('master_jenis_bukti', function (Blueprint $table) {
            $table->id('id_jenis_bukti');
            $table->string('nama_bukti')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_jenis_bukti');
    }
};