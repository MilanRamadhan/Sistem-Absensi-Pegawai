<?php

<<<<<<< HEAD
  namespace Database\Seeders;

  use Illuminate\Database\Console\Seeds\WithoutModelEvents;
  use Illuminate\Database\Seeder;

  class DatabaseSeeder extends Seeder
  {
      public function run(): void
      {
          $this->call([
              UserSeeder::class,
              // AbsensiSeeder::class, // Uncomment jika ada dan ingin di-seed
              // IzinTidakHadirSeeder::class, // Uncomment jika ada dan ingin di-seed
          ]);
      }
  }
=======
namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class, // Untuk admin dan beberapa pegawai dummy
            AbsensiSeeder::class, // Untuk data absensi dummy (opsional)
            IzinTidakHadirSeeder::class, // Untuk data izin dummy (opsional)
        ]);
    }
}
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
