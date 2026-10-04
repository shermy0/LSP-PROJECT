<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('jawaban_asesmen') && !Schema::hasColumn('jawaban_asesmen', 'pencapaian')) {
            Schema::table('jawaban_asesmen', function (Blueprint $table) {
                $table->text('pencapaian')->nullable();
            });
        }
    }

    public function down(): void
    {
        // Keep this repair non-destructive: the column may have predated this migration.
    }
};
