<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\CatatanKehadiran;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveRejectionNotification extends Notification
{
    use Queueable;
    protected $catatanKehadiran;

    /**
     * Create a new notification instance.
     */
    public function __construct(CatatanKehadiran $catatanKehadiran)
    {
        $this->catatanKehadiran = $catatanKehadiran;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
      $startDate = \Carbon\Carbon::parse($this->catatanKehadiran->tanggal_masuk)->translatedFormat('d M Y');
        $endDate = $this->catatanKehadiran->tanggal_selesai_izin
            ? \Carbon\Carbon::parse($this->catatanKehadiran->tanggal_selesai_izin)->translatedFormat('d M Y')
            : $startDate;

        return (new MailMessage)
            ->subject('Pengajuan Izin Ditolak')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Pengajuan izin Anda untuk **' . $this->catatanKehadiran->jenisKehadiran->name . '** pada **' . ($startDate === $endDate ? $startDate : "$startDate - $endDate") . '** telah **ditolak**.')
            ->line('Alasan penolakan: ' . ($this->catatanKehadiran->alasan_penolakan ?: 'Tidak ada alasan spesifik.'))
            ->line('Keterangan: ' . ($this->catatanKehadiran->keterangan_izin ?: '-'))
            ->line('Silakan hubungi tim HR untuk informasi lebih lanjut.')
            ->salutation('Salam, Tim HR');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
