<?php
// 2. migration untuk tabel penyesuaian_wajar_item
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penyesuaian_wajar_item', function (Blueprint $table) {
            $table->id('id_item');
            $table->unsignedBigInteger('id_penyesuaian');
            $table->tinyInteger('nomor_item')->unsigned(); // 1–8
            $table->boolean('dipilih')->nullable(); // true = Ya, false = Tidak
            $table->timestamps();

            $table->foreign('id_penyesuaian')->references('id_penyesuaian')->on('penyesuaian_wajar')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('penyesuaian_wajar_item');
    }
};