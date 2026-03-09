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
    Schema::table('unit_kompetensi', function (Blueprint $table) {
        $table->foreign('id_skema', 'uk_id_skema_foreign')
              ->references('id_skema')
              ->on('skema_sertifikasi')
              ->cascadeOnDelete();
    });
}

public function down(): void
{
    Schema::table('unit_kompetensi', function (Blueprint $table) {
        $table->dropForeign('uk_id_skema_foreign');
    });
}
};
