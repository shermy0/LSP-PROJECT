<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonan_persetujuan', function (Blueprint $table) {
            $table->id('id_permohonan_persetujuan');
            $table->unsignedBigInteger('id_permohonan');
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_admin')->nullable();
            $table->string('ttd_admin')->nullable();

            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('permohonan_persetujuan');
    }
};