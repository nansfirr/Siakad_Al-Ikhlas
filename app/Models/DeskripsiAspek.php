<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeskripsiAspek extends Model
{
    use HasFactory;

    protected $table = 'deskripsi_aspek';

    protected $primaryKey = 'id_deskripsi';

    protected $fillable = [
        'id_siswa',
        'id_aspek',
        'semester',
        'tahun_ajaran',
        'deskripsi',

        'foto1',
        'foto2',
        'foto3',
    ];

    public function siswa()
    {
        return $this->belongsTo(
            Siswa::class,
            'id_siswa',
            'id_siswa'
        );
    }

    public function aspek()
    {
        return $this->belongsTo(
            AspekPerkembangan::class,
            'id_aspek',
            'id_aspek'
        );
    }
}