<?php

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