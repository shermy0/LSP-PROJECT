<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('master_tugas_demonstrasi')) {
            return;
        }

        Schema::table('master_tugas_demonstrasi', function (Blueprint $table) {
            $columns = [
                'id_demonstrasi' => fn () => $table->unsignedBigInteger('id_demonstrasi')->nullable(),
                'id_asesor' => fn () => $table->unsignedBigInteger('id_asesor')->nullable(),
                'id_kelompok' => fn () => $table->unsignedBigInteger('id_kelompok')->nullable(),
                'isi_pertanyaan_demonstrasi' => fn () => $table->text('isi_pertanyaan_demonstrasi')->nullable(),
                'kunci_jawaban' => fn () => $table->text('kunci_jawaban')->nullable(),
                'file_path' => fn () => $table->string('file_path')->nullable(),
                'file_type' => fn () => $table->string('file_type', 50)->nullable(),
            ];

            foreach ($columns as $name => $addColumn) {
                if (!Schema::hasColumn('master_tugas_demonstrasi', $name)) {
                    $addColumn();
                }
            }

            // Tugas baru dibuat per skema dan kelompok. Kolom kompetensi tetap
            // dipakai oleh data lama, tetapi tidak wajib untuk form tugas ini.
            foreach (['id_unit', 'id_kuk'] as $column) {
                if (Schema::hasColumn('master_tugas_demonstrasi', $column)) {
                    $table->unsignedBigInteger($column)->nullable()->change();
                }
            }
        });
    }

    public function down(): void
    {
        // Preserve task data and compatibility columns during rollback.
    }
};
