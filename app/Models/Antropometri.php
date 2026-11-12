<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antropometri extends Model
{
    use HasFactory;

    protected $table = 'antropometri';
    protected $primaryKey = 'id_antropometri';
    protected $fillable = [
        'id_siswa', 'tinggi_badan', 'berat_badan',
        'lingkar_kepala', 'semester', 'tahun_ajaran'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }
}