<?php

namespace App\Models;

<<<<<<< HEAD
=======
// use Illuminate\Contracts\Auth\MustVerifyEmail;
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

<<<<<<< HEAD
=======
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
    protected $fillable = [
        'name',
        'email',
        'password',
<<<<<<< HEAD
        'role',
        'nip',
        'jabatan',
        'tanggal_lahir',
        'alamat',
        'lat_lokasi_kerja',
        'long_lokasi_kerja',
        'radius_toleransi',
    ];

=======
        'role', // Tambahkan
        'nip', // Tambahkan
        'jabatan', // Tambahkan
        'tanggal_lahir', // Tambahkan
        'alamat', // Tambahkan
        'lat_lokasi_kerja', // Tambahkan
        'long_lokasi_kerja', // Tambahkan
        'radius_toleransi', // Tambahkan
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'tanggal_lahir' => 'date',
=======
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
    ];

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

<<<<<<< HEAD
=======
    // Relasi ke IzinTidakHadir
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
    public function izinTidakHadir(): HasMany
    {
        return $this->hasMany(IzinTidakHadir::class);
    }

<<<<<<< HEAD
=======
    // Helper untuk cek role
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPegawai(): bool
    {
        return $this->role === 'pegawai';
    }
}