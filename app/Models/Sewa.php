<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sewa extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_penyewaan','nama_penyewa','telepon','email','alamat', 'kamera_id', 'jumlah_unit', 'tanggal_sewa','tanggal_kembali','metode_pembayaran','catatan','total_harga', 'user_id',
    ];

    protected $casts = [
        'tanggal_sewa' => 'date','tanggal_kembali' => 'date','total_harga' => 'integer',
    ];

    public function kamera()
    {
        return $this->belongsTo(Kamera::class);
    }
    
    public function kameras()
    {
        return $this->belongsToMany(Kamera::class, 'kamera_sewa')
                    ->withPivot('jumlah_unit', 'harga_satuan')
                    ->withTimestamps();
    }
}
