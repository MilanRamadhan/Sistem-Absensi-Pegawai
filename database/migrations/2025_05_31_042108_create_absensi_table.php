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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK to users
            $table->date('tanggal');
            $table->dateTime('waktu_masuk')->nullable();
            $table->dateTime('waktu_pulang')->nullable();
            $table->decimal('lat_masuk', 10, 7)->nullable();
            $table->decimal('long_masuk', 10, 7)->nullable();
            $table->decimal('lat_pulang', 10, 7)->nullable();
            $table->decimal('long_pulang', 10, 7)->nullable();
            $table->enum('status', ['hadir', 'izin', 'cuti', 'sakit', 'alpha'])->default('hadir');
            $table->text('keterangan')->nullable();
            $table->timestamps();
    
            $table->unique(['user_id', 'tanggal']); // Pastikan hanya satu absensi per pegawai per hari
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};