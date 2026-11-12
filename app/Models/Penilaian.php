<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';

    protected $primaryKey = 'id_penilaian';

    protected $fillable = [
        'id_siswa',
        'id_indikator',
        'nilai',

        'foto1',
        'foto2',
        'foto3',

        'semester',
        'tahun_ajaran',
    ];

    public function siswa()
    {
        return $this->belongsTo(
            Siswa::class,
            'id_siswa',
            'id_siswa'
        );
    }

    public function indikator()
    {
        return $this->belongsTo(
            IndikatorPenilaian::class,
            'id_indikator',
            'id_indikator'
        );
    }
}