<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pertanyaan') || Schema::hasColumn('pertanyaan', 'id_kelompok')) {
            return;
        }

        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->unsignedBigInteger('id_kelompok')->nullable();
        });

        if (Schema::hasTable('kelompok_pekerjaan')) {
            Schema::table('pertanyaan', function (Blueprint $table) {
                $table->foreign('id_kelompok', 'pertanyaan_kelompok_fk')
                    ->references('id_kelompok')
                    ->on('kelompok_pekerjaan')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        // This is a compatibility migration: fresh installs already receive
        // the column from the original create_pertanyaan migration. Dropping
        // it on rollback would break those installs.
    }
};
