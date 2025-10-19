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

            // 🔗 Relasi utama
            $table->unsignedBigInteger('asesi_id');       
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('skema_id');
            $table->unsignedBigInteger('id_tujuan')->nullable(); // relasi ke tabel tujuan_asesmen

            // 📅 Informasi permohonan
            $table->date('tgl_permohonan')->nullable(); // biar diisi di controller pakai now()

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

            // ✅ Foreign key
            $table->foreign('asesi_id')
                ->references('id_asesi')->on('asesi')
                ->onDelete('cascade');

            $table->foreign('admin_id')
                ->references('id_admin')->on('admin')
                ->onDelete('set null');

            $table->foreign('skema_id')
                ->references('id_skema')->on('skema_sertifikasi')
                ->onDelete('cascade');

            $table->foreign('id_tujuan')
                ->references('id_tujuan')->on('tujuan_asesmen')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('permohonan', function (Blueprint $table) {
            $table->dropForeign(['asesi_id']);
            $table->dropForeign(['admin_id']);
            $table->dropForeign(['skema_id']);
            $table->dropForeign(['id_tujuan']);
        });

        Schema::dropIfExists('permohonan');
    }
};
