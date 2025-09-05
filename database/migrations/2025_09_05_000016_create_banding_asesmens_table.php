<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('banding_asesmen', function (Blueprint $table) {
            $table->id('id_banding');
            $table->foreignId('id_asesi')->nullable()->constrained(table: 'asesi', column: 'id_asesi') ->nullOnDelete();      
            $table->date('tgl_asesmen')->nullable();
            $table->text('banding_dijelaskan')->nullable();
            $table->text('diskusi_dengan_asesor')->nullable();
            $table->text('alasan_banding')->nullable();
            $table->date('tgl_banding')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banding_asesmen');
    }
};
