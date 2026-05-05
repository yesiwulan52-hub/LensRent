<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamera extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode', 'nama', 'kategori', 'jumlah', 'harga', 'foto'
    ];

    protected $casts = [
        'harga' => 'integer',
        'jumlah' => 'integer',
    ];

    public function sewas()
    {
        return $this->belongsToMany(Sewa::class, 'kamera_sewa')
                    ->withPivot('jumlah_unit', 'harga_satuan')
                    ->withTimestamps();
    }

    public function scopeStokMenipis($query)
    {
        return $query->where('jumlah', '<', 3);
    }
}
