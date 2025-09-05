<?php
// 2025_09_05_000003_create_asesi_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('asesi', function (Blueprint $table) {
            $table->id('id_asesi');
            $table->foreignId('id_user')->nullable()->constrained(table: 'users', column: 'id')->onDelete('cascade')->nullOnDelete();
            $table->foreignId('id_asesor')->nullable()->constrained(table: 'asesor', column: 'id_asesor') ->nullOnDelete();      
            $table->string('nik')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('kebangsaan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->string('institusi')->nullable();
            $table->string('jabatan')->nullable();
            $table->text('alamat_kantor')->nullable();
            $table->string('telepon_kantor')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('asesi');
    }
};
