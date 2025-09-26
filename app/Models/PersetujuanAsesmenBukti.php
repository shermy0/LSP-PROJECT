<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PersetujuanAsesmenBukti extends Pivot
{
    protected $table = 'persetujuan_bukti';
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_persetujuan',
        'id_jenis_bukti',
        'dipilih',
    ];
}