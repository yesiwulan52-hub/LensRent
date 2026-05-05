<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamera;

class KameraSeeder extends Seeder
{
    public function run(): void
    {
        $kameras = [
            ['kode' => 'K001', 'nama' => 'Fujifilm X100F', 'kategori' => 'Mirrorless', 'jumlah' => 5, 'harga' => 150000, 'foto' => '/image/FujifilmX100F.jpg'],
            ['kode' => 'K002', 'nama' => 'Sony A7 III', 'kategori' => 'Mirrorless', 'jumlah' => 3, 'harga' => 250000, 'foto' => '/image/Sony_a7_III.jpg'],
            ['kode' => 'K003', 'nama' => 'Canon R5', 'kategori' => 'Mirrorless', 'jumlah' => 4, 'harga' => 230000, 'foto' => '/image/Canon_R5_camera.jpg'],
            ['kode' => 'K004', 'nama' => 'Nikon D750', 'kategori' => 'DSLR', 'jumlah' => 3, 'harga' => 200000, 'foto' => '/image/Nikon_d750.jpg'],
            ['kode' => 'K005', 'nama' => 'Canon EOS 90D', 'kategori' => 'DSLR', 'jumlah' => 6, 'harga' => 180000, 'foto' => null],
            ['kode' => 'K006', 'nama' => 'Sony ZV-E10', 'kategori' => 'Mirrorless', 'jumlah' => 2, 'harga' => 175000, 'foto' => null],
        ];

        foreach ($kameras as $k) {
            Kamera::firstOrCreate(
                ['kode' => $k['kode']],
                $k
            );
        }
    }
}
