<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsTo;
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2

class Absensi extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'absensi';
=======
    protected $table = 'absensi'; // Nama tabel
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
    protected $fillable = [
        'user_id',
        'tanggal',
        'waktu_masuk',
        'waktu_pulang',
        'lat_masuk',
        'long_masuk',
        'lat_pulang',
        'long_pulang',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_masuk' => 'datetime',
        'waktu_pulang' => 'datetime',
    ];

<<<<<<< HEAD
=======
    // Relasi ke User
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}