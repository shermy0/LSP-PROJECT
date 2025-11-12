<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penyesuaian_wajar_item', function (Blueprint $table) {
            $table->id('id_item');
            $table->unsignedBigInteger('id_penyesuaian');
            $table->enum('jenis_modifikasi', ['Fisik', 'Bahasa', 'Budaya', 'Teknologi', 'Waktu', 'Peralatan', 'Lainnya']);
            $table->boolean('dipilih')->nullable();
            $table->text('keterangan')->nullable();

            $table->foreign('id_penyesuaian')->references('id_penyesuaian')->on('penyesuaian_wajar')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyesuaian_wajar_item');
    }
};