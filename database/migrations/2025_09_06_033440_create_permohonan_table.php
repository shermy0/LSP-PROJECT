<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permohonan', function (Blueprint $table) {

            $table->id('id_permohonan');

            // 🔗 Relasi utama (ID di depan)
            $table->unsignedBigInteger('id_asesi');
            $table->unsignedBigInteger('id_admin')->nullable();
            $table->unsignedBigInteger('id_skema');
            $table->unsignedBigInteger('id_tujuan')->nullable();

            // 📅 Informasi permohonan
            $table->date('tgl_permohonan')->nullable();

            // 🧾 Status permohonan
            $table->enum('status', [
                'Diajukan',
                'Diperiksa',
                'Diterima',
                'Ditolak'
            ])->default('Diajukan');

            // 📝 Catatan admin/asesor
            $table->text('catatan')->nullable();

            $table->timestamps();

            // ✅ Foreign Key
            $table->foreign('id_asesi')
                ->references('id_asesi')
                ->on('asesi')
                ->onDelete('cascade');

            $table->foreign('id_admin')
                ->references('id_admin')
                ->on('admin')
                ->onDelete('set null');

            $table->foreign('id_skema')
                ->references('id_skema')
                ->on('skema_sertifikasi')
                ->onDelete('cascade');

            $table->foreign('id_tujuan')
                ->references('id_tujuan')
                ->on('tujuan_asesmen')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropForeign(['id_asesi']);
            $table->dropForeign(['id_admin']);
            $table->dropForeign(['id_skema']);
            $table->dropForeign(['id_tujuan']);
        });

        Schema::dropIfExists('permohonan');
    }
};