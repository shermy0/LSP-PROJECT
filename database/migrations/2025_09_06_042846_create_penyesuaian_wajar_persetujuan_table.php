<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penyesuaian_wajar_persetujuan', function (Blueprint $table) {
            $table->id('id_penyesuaian_persetujuan');
            $table->unsignedBigInteger('id_penyesuaian');
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable();
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();

            $table->foreign('id_penyesuaian')->references('id_penyesuaian')->on('penyesuaian_wajar')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyesuaian_wajar_persetujuan');
    }
};