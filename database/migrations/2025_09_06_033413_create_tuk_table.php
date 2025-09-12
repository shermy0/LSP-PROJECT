<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tuk', function (Blueprint $table) {
            $table->id('id_tuk');
            $table->string('nama_tuk')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('telepon')->nullable();
            $table->string('fax')->nullable();
            $table->string('jenis_tuk')->nullable();
            $table->text('alamat_tuk')->nullable();
            $table->string('email')->nullable();
            $table->enum('status_tuk', ['Aktif', 'Nonaktif'])->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tuk');
    }
};