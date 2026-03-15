<?php
// 3. migration untuk tabel penyesuaian_wajar_keterangan_item (menggantikan item_detail)
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('penyesuaian_wajar_keterangan_item', function (Blueprint $table) {
            $table->id('id_keterangan');
            $table->unsignedBigInteger('id_item');
            $table->text('keterangan'); // teks opsi yang dipilih
            $table->boolean('is_lainnya')->default(false); // true jika dari input manual
            $table->timestamps();

            $table->foreign('id_item')->references('id_item')->on('penyesuaian_wajar_item')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('penyesuaian_wajar_keterangan_item');
    }
};