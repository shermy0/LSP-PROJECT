<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('jawaban_asesmen') || !Schema::hasColumn('jawaban_asesmen', 'id_asesmen')) {
            return;
        }

        $column = collect(Schema::getColumns('jawaban_asesmen'))
            ->firstWhere('name', 'id_asesmen');

        if ($column && !$column['nullable']) {
            Schema::table('jawaban_asesmen', function (Blueprint $table) {
                $table->unsignedBigInteger('id_asesmen')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        // Keep this repair non-destructive; new answer rows may rely on a nullable value.
    }
};
