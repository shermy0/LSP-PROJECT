<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('skema_sertifikasi', function (Blueprint $table) {
            $table->id('id_skema');
            $table->string('kode_skema', 50);   // misal: J.59MTM00.010.1
            $table->string('nama_skema', 150);            // misal: Junior Operator Desain Grafis
            $table->string('judul_skema', 200)->nullable();
            $table->string('jenjang', 50)->nullable();   
            $table->string('bidang_keahlian', 100)->nullable(); 
            $table->text('deskripsi')->nullable();        // uraian singkat skema
            $table->enum('status_skema', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skema_sertifikasi');
    }
};
