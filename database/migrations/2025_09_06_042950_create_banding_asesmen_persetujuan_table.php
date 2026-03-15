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
        Schema::create('banding_asesmen_persetujuan', function (Blueprint $table) {
            $table->id('id_banding_persetujuan');
            $table->unsignedBigInteger('id_banding');
            $table->date('tgl_ttd_asesi')->nullable();
            $table->string('ttd_asesi')->nullable()->comment('Path file tanda tangan');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_banding')->references('id_banding')->on('banding_asesmen')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banding_asesmen_persetujuan');
    }
};