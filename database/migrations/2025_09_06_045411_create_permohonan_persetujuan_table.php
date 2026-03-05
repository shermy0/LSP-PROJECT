<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonan_persetujuan', function (Blueprint $table) {
            // gunakan id_permohonan sebagai primary key (one-to-one relation)
            $table->unsignedBigInteger('id_permohonan')->primary();

            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->date('tgl_ttd_admin')->nullable();
            $table->string('ttd_admin')->nullable();

            // timestamps agar Eloquent bisa mengisi created_at & updated_at
            $table->timestamps();

            // foreign key ke tabel permohonan (pastikan permohonan.id_permohonan ada)
            $table->foreign('id_permohonan')
                  ->references('id_permohonan')
                  ->on('permohonan')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('permohonan_persetujuan', function (Blueprint $table) {
            // drop foreign key sebelum drop table (nama FK otomatis bisa berbeda => gunakan dropForeign(['id_permohonan']))
            $table->dropForeign(['id_permohonan']);
        });
        Schema::dropIfExists('permohonan_persetujuan');
    }
};
