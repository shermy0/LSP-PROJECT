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
        Schema::create('hasil_asesmen_bukti', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto_increment primary key
            $table->unsignedBigInteger('id_hasil');
            $table->unsignedBigInteger('id_jenis_bukti');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_asesmen_bukti');
    }
};
