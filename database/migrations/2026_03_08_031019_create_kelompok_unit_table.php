<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up(): void
    {
        Schema::create('kelompok_unit', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_kelompok');
            $table->unsignedBigInteger('id_unit');
            $table->timestamps();

            $table->foreign('id_kelompok')
                ->references('id_kelompok')
                ->on('kelompok_pekerjaan')
                ->cascadeOnDelete();

            $table->foreign('id_unit')
                ->references('id_unit')
                ->on('unit_kompetensi')
                ->cascadeOnDelete();

            $table->unique(['id_kelompok', 'id_unit']); // cegah duplikat
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_unit');
    }
};
