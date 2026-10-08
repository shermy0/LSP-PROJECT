<?php
// 4. migration untuk tabel penyesuaian_wajar_potensi
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penyesuaian_wajar_potensi', function (Blueprint $table) {
            $table->id('id_potensi');
            $table->unsignedBigInteger('id_penyesuaian');
            $table->string('teks_potensi'); // deskripsi potensi
            $table->boolean('dipilih')->nullable(); // true jika dipilih
            $table->timestamps();

            $table->foreign('id_penyesuaian')->references('id_penyesuaian')->on('penyesuaian_wajar')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('penyesuaian_wajar_potensi');
    }
};