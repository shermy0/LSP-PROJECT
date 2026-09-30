<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilAsesmenPerangkat extends Model
{
    protected $table = 'hasil_asesmen_perangkat';
    protected $fillable = ['id_hasil', 'id_perangkat'];

    public function hasil()
    {
        return $this->belongsTo(HasilAsesmen::class, 'id_hasil');
    }

public function perangkat()
{
    return $this->belongsTo(PerangkatAsesmen::class, 'id_perangkat', 'id_perangkat');
}

}
