<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AspekPerkembangan extends Model
{
    use HasFactory;

    protected $table = 'aspek_perkembangan';

    protected $primaryKey = 'id_aspek';

    protected $fillable = [
        'nama_aspek',
        'urutan'
    ];

    // Relasi ke indikator
    public function indikatorPenilaian()
    {
        return $this->hasMany(
            IndikatorPenilaian::class,
            'id_aspek',
            'id_aspek'
        )->orderBy('urutan');
    }

    // Relasi ke deskripsi per aspek
    public function deskripsiAspek()
{
    return $this->hasMany(
        DeskripsiAspek::class,
        'id_aspek',
        'id_aspek'
    );
}
}