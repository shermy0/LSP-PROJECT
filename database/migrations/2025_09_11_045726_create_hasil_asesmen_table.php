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
    Schema::create('hasil_asesmen', function (Blueprint $table) {
        $table->id('id_hasil');
        $table->unsignedBigInteger('id_asesor');
        $table->unsignedBigInteger('id_asesi');
        $table->unsignedBigInteger('id_unit');
        $table->text('catatan')->nullable();
        $table->string('status')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_asesmen');
    }
};
