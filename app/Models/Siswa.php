<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'nis',
        'nama_siswa',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_wali',
        'foto',
        'id_kelas'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    // Penilaian indikator
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'id_siswa', 'id_siswa');
    }

    // Deskripsi per aspek
    public function deskripsiAspek()
{
    return $this->hasMany(
        DeskripsiAspek::class,
        'id_siswa',
        'id_siswa'
    );
}

    // Nilai kegiatan
    public function nilaiKegiatan()
    {
        return $this->hasMany(NilaiKegiatan::class, 'id_siswa', 'id_siswa');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'id_siswa', 'id_siswa');
    }

    public function presensiRaport()
    {
        return $this->hasMany(PresensiRaport::class, 'id_siswa', 'id_siswa');
    }

    public function antropometri()
    {
        return $this->hasMany(Antropometri::class, 'id_siswa', 'id_siswa');
    }

    public function refleksiGuru()
    {
        return $this->hasMany(RefleksiGuru::class, 'id_siswa', 'id_siswa');
    }
    
    
}