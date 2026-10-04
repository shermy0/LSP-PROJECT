<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('demonstrasi')) {
            return;
        }

        Schema::table('demonstrasi', function (Blueprint $table) {
            if (!Schema::hasColumn('demonstrasi', 'id_skema')) {
                $table->unsignedBigInteger('id_skema')->nullable()->after('id_demonstrasi');
            }

            if (!Schema::hasColumn('demonstrasi', 'timer')) {
                $table->unsignedInteger('timer')->nullable();
            }

            if (!Schema::hasColumn('demonstrasi', 'timescap')) {
                $table->timestamp('timescap')->nullable();
            }

            // Kolom-kolom ini berasal dari struktur demonstrasi lama yang
            // menyimpan data per asesmen. Form setup skema tidak mengisinya.
            foreach (['id_asesmen', 'id_tuk', 'id_kuk', 'id_asesor'] as $column) {
                if (Schema::hasColumn('demonstrasi', $column)) {
                    $table->unsignedBigInteger($column)->nullable()->change();
                }
            }
        });
    }

    public function down(): void
    {
        // Keep added columns and nullable legacy references so records created
        // after this migration are not destroyed by a rollback.
    }
};
