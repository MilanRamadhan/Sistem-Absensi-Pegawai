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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', ['admin', 'pegawai'])->default('pegawai'); // Add role
            $table->string('nip')->unique()->nullable(); // Add NIP
            $table->string('jabatan')->nullable(); // Add Jabatan
            $table->date('tanggal_lahir')->nullable(); // Add Tanggal Lahir
            $table->text('alamat')->nullable(); // Add Alamat
            $table->decimal('lat_lokasi_kerja', 10, 7)->nullable(); // Add Latitude
            $table->decimal('long_lokasi_kerja', 10, 7)->nullable(); // Add Longitude
            $table->integer('radius_toleransi')->default(50); // Add Radius Toleransi
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};