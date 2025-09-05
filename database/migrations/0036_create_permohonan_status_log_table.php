<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('permohonan_status_log', function (Blueprint $table) {
            $table->id('id_permohonan_status_log');
            $table->integer('id_status_permohonan')->nullable();
            $table->foreignId('id_permohonan')->nullable()->constrained(table: 'permohonan', column: 'id_permohonan') ->nullOnDelete();
            $table->text('keterangan')->nullable();
            $table->date('changed_at')->nullable();
            $table->integer('changed_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permohonan_status_log');
    }
};
