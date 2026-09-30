<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstrumenAsesmen extends Model
{
    use HasFactory;

    protected $table = 'instrumen_asesmen'; // nama tabel sesuai di database kamu
    protected $primaryKey = 'id_instrumen'; // kalau primary key bukan "id"
    public $timestamps = false; // kalau tabel ga punya created_at & updated_at
}