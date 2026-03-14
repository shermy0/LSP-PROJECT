<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penyesuaian_wajar', function (Blueprint $table) {
            $table->id('id_penyesuaian');
            $table->unsignedBigInteger('id_permohonan'); // ganti id_asesmen dengan id_permohonan
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_asesor');
            
            // Hasil kesepakatan (teks)
            $table->text('hasil_penyesuaian')->nullable();
            $table->text('acuan_pembanding')->nullable();
            $table->text('metode_asesmen')->nullable();
            $table->text('instrumen_asesmen')->nullable();

            // Status untuk alur kerja
            $table->enum('status', ['draf', 'menunggu_asesi', 'menunggu_asesor', 'selesai'])->default('draf');

            // Timestamps
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_permohonan')->references('id_permohonan')->on('permohonan')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyesuaian_wajar');
    }
};