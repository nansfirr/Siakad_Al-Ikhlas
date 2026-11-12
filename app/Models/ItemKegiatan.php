<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemKegiatan extends Model
{
    use HasFactory;

    protected $table = 'item_kegiatan';

    protected $primaryKey = 'id_item';

    protected $fillable = [
        'id_katagori',
        'nama_item',
        'urutan'
    ];

    public function katagori()
    {
        return $this->belongsTo(
            KatagoriKegiatan::class,
            'id_katagori',
            'id_katagori'
        );
    }

    public function nilaiKegiatan()
    {
        return $this->hasMany(
            NilaiKegiatan::class,
            'id_item',
            'id_item'
        );
    }
}