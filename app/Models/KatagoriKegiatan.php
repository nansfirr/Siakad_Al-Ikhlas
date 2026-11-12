<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KatagoriKegiatan extends Model
{
    use HasFactory;

    protected $table = 'katagori_kegiatan';
    protected $primaryKey = 'id_katagori';
    protected $fillable = ['nama_katagori', 'urutan'];

    public function itemKegiatan()
    {
        return $this->hasMany(ItemKegiatan::class, 'id_katagori', 'id_katagori');
    }
}