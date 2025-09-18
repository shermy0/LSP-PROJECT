<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('persetujuan_asesmen_persetujuan', function (Blueprint $table) {
            $table->id('id_persetujuan_ttd');
            $table->unsignedBigInteger('id_persetujuan');
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();

            $table->foreign('id_persetujuan')->references('id_persetujuan')->on('persetujuan_asesmen')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('persetujuan_asesmen_persetujuan');
    }
};