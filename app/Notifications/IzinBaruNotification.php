<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\IzinTidakHadir; // <-- Import model IzinTidakHadir

class IzinBaruNotification extends Notification
{
    use Queueable;

    public $izin; // Properti untuk menyimpan objek izin

    /**
     * Create a new notification instance.
     */
    public function __construct(IzinTidakHadir $izin) // Terima objek izin sebagai parameter
    {
        $this->izin = $izin;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // Anda bisa memilih channel notifikasi: mail, database, broadcast, etc.
        // Untuk contoh sederhana, kita pakai 'database' (disimpan di tabel notifications)
        return ['database']; // Atau ['mail'] jika Anda sudah mengatur mail driver
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Implementasi ini hanya jika Anda menggunakan channel 'mail'
        return (new MailMessage)
                    ->line('Ada pengajuan izin baru dari ' . $this->izin->user->name . '.')
                    ->action('Lihat Izin', url('/admin/izin/' . $this->izin->id . '/edit')) // Link ke detail izin di Filament
                    ->line('Alasan: ' . $this->izin->alasan);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // Ini akan disimpan di kolom 'data' di tabel 'notifications' jika via 'database'
        return [
            'izin_id' => $this->izin->id,
            'user_id' => $this->izin->user_id,
            'user_name' => $this->izin->user->name,
            'jenis_izin' => $this->izin->jenis_izin,
            'tanggal_mulai' => $this->izin->tanggal_mulai->format('Y-m-d'),
            'tanggal_selesai' => $this->izin->tanggal_selesai->format('Y-m-d'),
            'alasan' => $this->izin->alasan,
            'url' => url('/admin/izin/' . $this->izin->id . '/edit'),
        ];
    }
}