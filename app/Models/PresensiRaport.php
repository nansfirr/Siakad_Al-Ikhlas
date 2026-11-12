<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiRaport extends Model
{
    use HasFactory;

    protected $table = 'presensi_raport';
    protected $primaryKey = 'id_presensi_raport';
    protected $fillable = [
        'id_siswa', 'semester', 'tahun_ajaran',
        'hadir', 'izin', 'tanpa_keterangan'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
}