<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pegawai;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pegawai::create([
            'nama' => 'Budi Santoso',
            'nip' => '199001152015011001', // Contoh NIP
            'jabatan' => 'Manajer Operasional',
            'tanggal_lahir' => '1990-01-15',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta Pusat'
        ]);

        Pegawai::create([
            'nama' => 'Siti Aminah',
            'nip' => '199203202018022002', // Contoh NIP
            'jabatan' => 'Staf Keuangan',
            'tanggal_lahir' => '1992-03-20',
            'alamat' => 'Jl. Sudirman No. 5, Bandung'
        ]);

        Pegawai::create([
            'nama' => 'Agus Dharma',
            'nip' => '198507222010051003',
            'jabatan' => 'Kepala Divisi Pemasaran',
            'tanggal_lahir' => '1985-07-22',
            'alamat' => 'Jl. Kebon Jeruk No. 22, Surabaya'
        ]);

        // Anda juga bisa menggunakan loop untuk menghasilkan banyak data dummy
        // for ($i = 4; $i <= 10; $i++) {
        //     Pegawai::create([
        //         'nama' => 'Pegawai Dummy ' . $i,
        //         'nip' => '19950' . str_pad($i, 2, '0', STR_PAD_LEFT) . '20200' . str_pad($i, 2, '0', STR_PAD_LEFT) . '0' . $i,
        //         'jabatan' => 'Staf Bidang ' . ($i % 3 + 1),
        //         'tanggal_lahir' => '1995-0' . ($i % 12 + 1) . '-' . ($i % 28 + 1),
        //         'alamat' => 'Alamat Dummy No. ' . $i . ', Kota Dummy'
        //     ]);
        // }
    }
}