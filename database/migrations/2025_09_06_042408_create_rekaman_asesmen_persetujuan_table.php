<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rekaman_asesmen_persetujuan', function (Blueprint $table) {
            $table->id('id_rekaman_persetujuan');
            $table->unsignedBigInteger('id_rekaman');
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();

            $table->foreign('id_rekaman')->references('id_rekaman')->on('rekaman_asesmen')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekaman_asesmen_persetujuan');
    }
};