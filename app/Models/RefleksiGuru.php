<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefleksiGuru extends Model
{
    use HasFactory;

    protected $table = 'refleksi_guru';
    protected $primaryKey = 'id_refleksi';
    protected $fillable = [
        'id_siswa', 'catatan_guru',
        'semester', 'tahun_ajaran'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
}