<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSekolah extends Model
{
    protected $table = 'pengaturan_sekolah';

    protected $primaryKey = 'id_pengaturan';

    protected $fillable = [
        'nama_sekolah',
        'alamat',
        'telepon',
        'email',
        'kepala_sekolah',
        'nip_kepala',
        'logo',
    ];
}