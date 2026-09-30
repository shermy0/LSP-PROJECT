<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pertanyaan')) {
            return;
        }

        $hasUnitColumn = Schema::hasColumn('pertanyaan', 'id_unit');

        // Database lokal lama memiliki foreign key pada id_unit, tetapi kolom
        // ini sekarang menyimpan daftar ID unit dalam JSON sehingga tidak bisa
        // sekaligus menjadi foreign key ke satu baris unit.
        $foreignKeys = $hasUnitColumn ? DB::select(
            'SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE
             WHERE TABLE_SCHEMA = DATABASE()
               AND TABLE_NAME = ?
               AND COLUMN_NAME = ?
               AND REFERENCED_TABLE_NAME IS NOT NULL',
            ['pertanyaan', 'id_unit']
        ) : [];

        foreach ($foreignKeys as $foreignKey) {
            Schema::table('pertanyaan', function (Blueprint $table) use ($foreignKey) {
                $table->dropForeign($foreignKey->CONSTRAINT_NAME);
            });
        }

        if (! $hasUnitColumn) {
            Schema::table('pertanyaan', function (Blueprint $table) {
                $table->longText('id_unit')->nullable();
            });
            return;
        }

        Schema::table('pertanyaan', function (Blueprint $table) {
            // Lisan/esai/PG dapat mencakup banyak unit; simpan daftar ID sebagai JSON.
            $table->longText('id_unit')->nullable()->change();
        });

        // Normalisasi nilai lama (satu ID integer) menjadi array JSON agar
        // kode yang membaca daftar unit selalu menerima bentuk yang sama.
        foreach (DB::table('pertanyaan')->whereNotNull('id_unit')->get(['id_pertanyaan', 'id_unit']) as $row) {
            $decoded = json_decode((string) $row->id_unit, true);
            if (! is_array($decoded)) {
                DB::table('pertanyaan')
                    ->where('id_pertanyaan', $row->id_pertanyaan)
                    ->update(['id_unit' => json_encode([(string) $row->id_unit])]);
            }
        }
    }

    public function down(): void
    {
        // Converting to an integer would discard multi-unit associations.
    }
};
