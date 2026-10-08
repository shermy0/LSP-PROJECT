<?php
// 5. migration untuk tabel penyesuaian_wajar_persetujuan
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penyesuaian_wajar_persetujuan', function (Blueprint $table) {
            $table->id('id_penyesuaian_persetujuan');
            $table->unsignedBigInteger('id_penyesuaian');
            $table->date('tgl_ttd_asesor')->nullable();
            $table->string('ttd_asesor')->nullable(); // path file tanda tangan atau string
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable();
            $table->timestamps();

            $table->foreign('id_penyesuaian')->references('id_penyesuaian')->on('penyesuaian_wajar')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('penyesuaian_wajar_persetujuan');
    }
};