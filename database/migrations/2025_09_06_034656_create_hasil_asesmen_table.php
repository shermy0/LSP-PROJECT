<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hasil_asesmen', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->unsignedBigInteger('id_asesor');
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_unit');
            $table->unsignedBigInteger('id_instrumen')->nullable();
            $table->unsignedBigInteger('id_jenis_bukti')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['kompeten', 'belum kompeten'])->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_asesor')->references('id_asesor')->on('asesor')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
            $table->foreign('id_unit')->references('id_unit')->on('unit_kompetensi')->onDelete('cascade');
            $table->foreign('id_instrumen')->references('id_instrumen')->on('instrumen_asesmen')->onDelete('set null');
            $table->foreign('id_jenis_bukti')->references('id_jenis_bukti')->on('master_jenis_bukti')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hasil_asesmen');
    }
};