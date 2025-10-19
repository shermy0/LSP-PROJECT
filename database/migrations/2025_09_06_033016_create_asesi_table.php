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

            // Relasi ke user (akun login)
            $table->unsignedBigInteger('user_id');

            // Opsional: relasi ke asesor (bila sudah ditugaskan)
            $table->unsignedBigInteger('asesor_id')->nullable();

            // 🧍 Data Pribadi
            $table->string('nik', 20)->nullable();
            $table->string('nama_lengkap', 100)->nullable();
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('kebangsaan', 50)->nullable();
            $table->text('alamat_rumah')->nullable();
            $table->string('kode_pos_rumah', 10)->nullable();
            $table->string('telepon_rumah', 20)->nullable();
            $table->string('telepon_hp', 20)->nullable();
            $table->string('email', 100)->nullable();

            // 🎓 Data Pendidikan
            $table->string('kualifikasi_pendidikan', 100)->nullable();

            // 💼 Data Pekerjaan Sekarang
            $table->string('nama_institusi', 150)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->text('alamat_kantor')->nullable();
            $table->string('kode_pos_kantor', 10)->nullable();
            $table->string('telepon_kantor', 20)->nullable();
            $table->string('fax_kantor', 20)->nullable();
            $table->string('email_kantor', 100)->nullable();

            $table->timestamps();

            // 🔗 Relasi ke tabel lain
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('asesor_id')
                ->references('id_asesor')->on('asesor')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('asesi');
    }
};
