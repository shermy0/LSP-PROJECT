<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asesmen_status_log', function (Blueprint $table) {
            $table->id('id_asesmen_status_log');
            $table->foreignId('id_asesmen')->nullable()->constrained(table: 'asesmen', column: 'id_asesmen') ->nullOnDelete();
            $table->integer('id_status_asesmen')->nullable();
            $table->text('keterangan')->nullable();
            $table->dateTime('changed_at')->nullable();
            $table->integer('changed_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asesmen_status_log');
    }
};
