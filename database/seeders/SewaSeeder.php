<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sewa;
use App\Models\Kamera;

class SewaSeeder extends Seeder
{
    public function run(): void
    {
        $kameraK001 = Kamera::where('kode', 'K001')->first();
        $kameraK002 = Kamera::where('kode', 'K002')->first();
        $kameraK003 = Kamera::where('kode', 'K003')->first();
        $kameraK004 = Kamera::where('kode', 'K004')->first();

        if (!$kameraK001 || !$kameraK002 || !$kameraK003 || !$kameraK004) {
            $this->command->info('Data kamera tidak lengkap. Jalankan KameraSeeder dulu.');
            return;
        }

        $sewas = [
            [
                'id_penyewaan'   => 'SW001',
                'nama_penyewa'   => 'Andi Wijaya',
                'telepon'        => '081234567890',
                'email'          => 'andi@example.com',
                'alamat'         => 'Jl. Merdeka No. 10, Jakarta',
                'tanggal_sewa'   => '2025-05-01',
                'tanggal_kembali'=> '2025-05-03',   // 2 hari
                'metode_pembayaran' => 'Transfer Bank',
                'catatan'        => 'Ambil sendiri',
                // total_harga akan dihitung nanti
            ],
            [
                'id_penyewaan'   => 'SW002',
                'nama_penyewa'   => 'Budi Santoso',
                'telepon'        => '082345678901',
                'email'          => 'budi@example.com',
                'alamat'         => 'Jl. Sudirman No. 5, Bandung',
                'tanggal_sewa'   => '2025-05-02',
                'tanggal_kembali'=> '2025-05-05',   // 3 hari
                'metode_pembayaran' => 'E-Wallet',
                'catatan'        => 'Kirim ke alamat',
            ],
            [
                'id_penyewaan'   => 'SW003',
                'nama_penyewa'   => 'Citra Lestari',
                'telepon'        => '083456789012',
                'email'          => 'citra@example.com',
                'alamat'         => 'Jl. Diponegoro No. 8, Surabaya',
                'tanggal_sewa'   => '2025-05-03',
                'tanggal_kembali'=> '2025-05-04',   // 1 hari
                'metode_pembayaran' => 'Cash',
                'catatan'        => null,
            ],
            [
                'id_penyewaan'   => 'SW004',
                'nama_penyewa'   => 'Dewi Sartika',
                'telepon'        => '085678901234',
                'email'          => 'dewi@example.com',
                'alamat'         => 'Jl. Ahmad Yani No. 12, Surabaya',
                'tanggal_sewa'   => '2025-05-10',
                'tanggal_kembali'=> '2025-05-15',   // 5 hari
                'metode_pembayaran' => 'Transfer Bank',
                'catatan'        => 'Butuh charger ekstra',
            ],
            [
                'id_penyewaan'   => 'SW005',
                'nama_penyewa'   => 'Eko Prasetyo',
                'telepon'        => '087890123456',
                'email'          => 'eko@example.com',
                'alamat'         => 'Jl. Pahlawan No. 3, Semarang',
                'tanggal_sewa'   => '2025-05-12',
                'tanggal_kembali'=> '2025-05-14',   // 2 hari
                'metode_pembayaran' => 'E-Wallet',
                'catatan'        => 'Pengambilan setelah jam 10 pagi',
            ],
        ];

        $hitungHari = function ($tglSewa, $tglKembali) {
            return (strtotime($tglKembali) - strtotime($tglSewa)) / (60 * 60 * 24) ;
        };

        foreach ($sewas as $data) {
            $hari = $hitungHari($data['tanggal_sewa'], $data['tanggal_kembali']);

            $attachments = [];
             switch ($data['id_penyewaan']) {
                case 'SW001':
                    $attachments[$kamera1->id] = ['jumlah_unit' => 1, 'harga_satuan' => $kamera1->harga];
                    $attachments[$kamera2->id] = ['jumlah_unit' => 2, 'harga_satuan' => $kamera2->harga];
                    break;
                case 'SW002':
                    $attachments[$kamera3->id] = ['jumlah_unit' => 1, 'harga_satuan' => $kamera3->harga];
                    break;
            }

             $total = 0;
            foreach ($attachments as $kId => $pivot) {
                $total += $pivot['jumlah_unit'] * $pivot['harga_satuan'] * $hari;
            }

            $sewa = Sewa::create(array_merge($data, ['total_harga' => $total]));

            foreach ($attachments as $kId => $pivot) {
                $sewa->kameras()->attach($kameraId, $pivot);
            }
        }

        $this->command->info('SewaSeeder berhasil menambahkan data dummy penyewaan (many-to-many).');
    }
}
