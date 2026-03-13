<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
       Schema::create('pmo_tanggapan', function (Blueprint $table) {
            $table->id('id_pmo_tanggapan');
            $table->unsignedBigInteger('id_pmo');
            $table->unsignedBigInteger('id_asesi')->nullable(); // ✅ tambah ini
            $table->unsignedBigInteger('id_pmo_pertanyaan');
            $table->unsignedBigInteger('id_unit')->nullable(); // ✅ ubah jadi nullable
            $table->text('tanggapan')->nullable();
            $table->enum('pencapaian', ['Ya', 'Tidak'])->nullable();

            $table->foreign('id_pmo')->references('id_pmo')->on('pmo')->onDelete('cascade');
            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade'); // ✅ tambah ini
            $table->foreign('id_pmo_pertanyaan')->references('id_pmo_pertanyaan')->on('pmo_pertanyaan')->onDelete('cascade');
            $table->foreign('id_unit')->references('id_unit')->on('unit_kompetensi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pmo_tanggapan');
    }
};