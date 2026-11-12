<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKegiatan extends Model
{
    use HasFactory;

    protected $table = 'nilai_kegiatan';
    protected $primaryKey = 'id_nilai_kegiatan';
    protected $fillable = [
        'id_siswa', 'id_item', 'nilai',
        'semester', 'tahun_ajaran'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id_siswa');
    }

    public function itemKegiatan()
    {
        return $this->belongsTo(ItemKegiatan::class, 'id_item', 'id_item');
    }
}