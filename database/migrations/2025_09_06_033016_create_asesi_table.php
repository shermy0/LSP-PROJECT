<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asesi', function (Blueprint $table) {
            $table->id('id_asesi');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('asesor_id')->nullable();
            $table->string('nik')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('kebangsaan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('kelas')->nullable();
            $table->string('bidang_keahlian')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('institusi')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat_kantor')->nullable();
            $table->string('telepon_kantor')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('asesor_id')->references('id_asesor')->on('asesor')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesi');
    }
};