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
        Schema::create('izin_tidak_hadir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // FK to users
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->string('jenis_izin'); // e.g., Sakit, Pribadi, Cuti
            $table->text('alasan');
            $table->string('bukti_file')->nullable(); // Path to uploaded file
            $table->enum('status_admin', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_tidak_hadir');
    }
};