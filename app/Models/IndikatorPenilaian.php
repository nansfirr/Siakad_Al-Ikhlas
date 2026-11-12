<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndikatorPenilaian extends Model
{
    use HasFactory;

    protected $table = 'indikator_penilaian';

    protected $primaryKey = 'id_indikator';

    protected $fillable = [
        'id_aspek',
        'capaian_pembelajaran',
        'urutan'
    ];

    // Relasi ke Aspek Perkembangan
    public function aspek()
    {
        return $this->belongsTo(
            AspekPerkembangan::class,
            'id_aspek',
            'id_aspek'
        );
    }

    // Relasi ke Penilaian
    public function penilaian()
    {
        return $this->hasMany(
            Penilaian::class,
            'id_indikator',
            'id_indikator'
        );
    }
}