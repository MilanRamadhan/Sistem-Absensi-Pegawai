<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsTo;
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2

class IzinTidakHadir extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'izin_tidak_hadir';
=======
    protected $table = 'izin_tidak_hadir'; // Nama tabel
>>>>>>> 1871dce885169eddbdd6e1f679e891f946aa85e2
    protected $fillable = [
        'user_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis_izin',
        'alasan',
        'bukti_file',
        'status_admin',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
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