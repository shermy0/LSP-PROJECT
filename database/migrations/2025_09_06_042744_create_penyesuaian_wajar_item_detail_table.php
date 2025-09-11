<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('penyesuaian_wajar_item_detail', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_item');
            $table->text('alasan')->nullable();
            $table->text('catatan')->nullable();

            $table->foreign('id_item')->references('id_item')->on('penyesuaian_wajar_item')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penyesuaian_wajar_item_detail');
    }
};