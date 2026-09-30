<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meninjau_asesmen', function (Blueprint $table) {
            $table->id('id_meninjau');
            $table->unsignedBigInteger('id_asesmen');

            // Rencana Asesmen
            $table->boolean('rencana_valid')->default(0);
            $table->boolean('rencana_reliabel')->default(0);
            $table->boolean('rencana_fleksibel')->default(0);
            $table->boolean('rencana_adil')->default(0);

            // Persiapan Asesmen
            $table->boolean('persiapan_valid')->default(0);
            $table->boolean('persiapan_reliabel')->default(0);
            $table->boolean('persiapan_fleksibel')->default(0);
            $table->boolean('persiapan_adil')->default(0);

            // Implementasi Asesmen
            $table->boolean('implementasi_valid')->default(0);
            $table->boolean('implementasi_reliabel')->default(0);
            $table->boolean('implementasi_fleksibel')->default(0);
            $table->boolean('implementasi_adil')->default(0);

            // Keputusan Asesmen
            $table->boolean('keputusan_valid')->default(0);
            $table->boolean('keputusan_reliabel')->default(0);
            $table->boolean('keputusan_fleksibel')->default(0);
            $table->boolean('keputusan_adil')->default(0);

            // Umpan Balik
            $table->boolean('umpan_valid')->default(0);
            $table->boolean('umpan_reliabel')->default(0);
            $table->boolean('umpan_fleksibel')->default(0);
            $table->boolean('umpan_adil')->default(0);

            // Rekomendasi 1
            $table->text('rekomendasi1')->nullable();

            // Konsistensi
            $table->string('konsistensi_task', 5)->nullable();
            $table->string('konsistensi_task_mgmt', 5)->nullable();
            $table->string('konsistensi_contingency', 5)->nullable();
            $table->string('konsistensi_jobrole', 5)->nullable();
            $table->string('konsistensi_transfer', 5)->nullable();

            // Bukti
            $table->string('bukti_task', 5)->nullable();
            $table->string('bukti_task_mgmt', 5)->nullable();
            $table->string('bukti_contingency', 5)->nullable();
            $table->string('bukti_jobrole', 5)->nullable();
            $table->string('bukti_transfer', 5)->nullable();

            // Rekomendasi 2
            $table->text('rekomendasi2')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meninjau_asesmen');
    }
};
