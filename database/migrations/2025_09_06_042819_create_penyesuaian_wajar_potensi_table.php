<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penyesuaian_wajar_potensi', function (Blueprint $table) {
            $table->id('id_potensi');
            $table->unsignedBigInteger('id_penyesuaian');
            $table->string('potensi')->nullable();
            $table->boolean('dipilih')->nullable();

            $table->foreign('id_penyesuaian')->references('id_penyesuaian')->on('penyesuaian_wajar')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyesuaian_wajar_potensi');
    }
};