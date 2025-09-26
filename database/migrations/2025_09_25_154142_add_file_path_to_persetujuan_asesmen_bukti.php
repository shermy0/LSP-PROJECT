<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('persetujuan_asesmen_bukti', function (Blueprint $table) {
            if (!Schema::hasColumn('persetujuan_asesmen_bukti', 'file_path')) {
                $table->string('file_path')->nullable()->after('id_jenis_bukti');
            }
        });
    }

    public function down()
    {
        Schema::table('persetujuan_asesmen_bukti', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
};

