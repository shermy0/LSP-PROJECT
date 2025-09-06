<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('banding_asesmen', function (Blueprint $table) {
            $table->id('id_banding');
            $table->unsignedBigInteger('id_asesi');
            $table->date('tgl_asesmen')->nullable();
            $table->text('banding_dijelaskan')->nullable();
            $table->text('diskusi_dengan_asesor')->nullable();
            $table->text('alasan_banding')->nullable();
            $table->date('tgl_banding')->nullable();

            $table->foreign('id_asesi')->references('id_asesi')->on('asesi')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('banding_asesmen');
    }
};