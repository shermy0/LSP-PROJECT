<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pmo_pertanyaan', function (Blueprint $table) {
            // Lepas dulu foreign key-nya
            $table->dropForeign(['id_unit']);
        });

        Schema::table('pmo_pertanyaan', function (Blueprint $table) {
            // Ubah kolom id_unit jadi JSON
            $table->json('id_unit')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pmo_pertanyaan', function (Blueprint $table) {
            // Balikin ke integer
            $table->unsignedBigInteger('id_unit')->nullable()->change();

            // Tambahkan lagi foreign key-nya (ke tabel unit)
            $table->foreign('id_unit')->references('id')->on('unit')->onDelete('cascade');
        });
    }
};
