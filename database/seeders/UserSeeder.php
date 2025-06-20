<?php

  namespace Database\Seeders;

  use Illuminate\Database\Console\Seeds\WithoutModelEvents;
  use Illuminate\Database\Seeder;
  use App\Models\User;
  use Illuminate\Support\Facades\Hash;

  class UserSeeder extends Seeder
  {
      public function run(): void
      {
          User::firstOrCreate(
              ['email' => 'admin@example.com'],
              [
                  'name' => 'Admin Utama',
                  'password' => Hash::make('password'),
                  'role' => 'admin',
                  'nip' => null,
                  'jabatan' => 'Administrator Sistem',
                  'tanggal_lahir' => null,
                  'alamat' => null,
                  'lat_lokasi_kerja' => -6.2088, // Contoh: Jakarta
                  'long_lokasi_kerja' => 106.8456,
                  'radius_toleransi' => 100,
              ]
          );

          User::firstOrCreate(
              ['email' => 'budi@example.com'],
              [
                  'name' => 'Budi Santoso',
                  'password' => Hash::make('password'),
                  'role' => 'pegawai',
                  'nip' => 'PEG001',
                  'jabatan' => 'Staff IT',
                  'tanggal_lahir' => '1990-05-10',
                  'alamat' => 'Jl. Kebon Raya No. 1, Jakarta',
                  'lat_lokasi_kerja' => -6.2088,
                  'long_lokasi_kerja' => 106.8456,
                  'radius_toleransi' => 50,
              ]
          );

          User::firstOrCreate(
              ['email' => 'siti@example.com'],
              [
                  'name' => 'Siti Aminah',
                  'password' => Hash::make('password'),
                  'role' => 'pegawai',
                  'nip' => 'PEG002',
                  'jabatan' => 'Staff Keuangan',
                  'tanggal_lahir' => '1992-08-22',
                  'alamat' => 'Jl. Mawar Indah No. 5, Bogor',
                  'lat_lokasi_kerja' => -6.2088,
                  'long_lokasi_kerja' => 106.8456,
                  'radius_toleransi' => 50,
              ]
          );
      }
  }