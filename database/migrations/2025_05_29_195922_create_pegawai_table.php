<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis (primary key)
            $table->string('nama'); // Varchar
            $table->string('nip')->unique(); // Varchar, harus unik
            $table->string('jabatan'); // Varchar
            $table->date('tanggal_lahir'); // Tanggal
            $table->text('alamat'); // Teks panjang
            $table->timestamps(); // Kolom created_at dan updated_at otomatis (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};