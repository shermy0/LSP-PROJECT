<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pertanyaan') || ! Schema::hasColumn('pertanyaan', 'id_unit')) {
            return;
        }

        // Database lokal lama memiliki foreign key pada id_unit, tetapi kolom
        // ini sekarang menyimpan daftar ID unit dalam JSON sehingga tidak bisa
        // sekaligus menjadi foreign key ke satu baris unit.
        $foreignKeys = DB::select(
            'SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND COLUMN_NAME = ?
               AND REFERENCED_TABLE_NAME IS NOT NULL',
            ['pertanyaan', 'id_unit']
        );

        foreach ($foreignKeys as $foreignKey) {
            Schema::table('pertanyaan', function (Blueprint $table) use ($foreignKey) {
                $table->dropForeign($foreignKey->CONSTRAINT_NAME);
            });
        }

        Schema::table('pertanyaan', function (Blueprint $table) {
            // Pertanyaan lisan/esai/PG boleh mencakup beberapa unit; controller
            // menyimpan daftar ID unit dalam format JSON di kolom ini.
            $table->longText('id_unit')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Converting to an integer would discard multi-unit associations.
    }
};
