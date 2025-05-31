<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import

class IzinTidakHadir extends Model
{
    use HasFactory;

    protected $table = 'izin_tidak_hadir'; // Nama tabel
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

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}