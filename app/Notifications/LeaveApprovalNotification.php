<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\CatatanKehadiran;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LeaveApprovalNotification extends Notification
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
    public function toMail(object $notifiable)
    {
        $startDate = \Carbon\Carbon::parse($this->catatanKehadiran->tanggal_masuk)->translatedFormat('d M Y');
        $endDate = $this->catatanKehadiran->tanggal_selesai_izin
            ? \Carbon\Carbon::parse($this->catatanKehadiran->tanggal_selesai_izin)->translatedFormat('d M Y')
            : $startDate;

        return (new MailMessage)
            ->subject('Pengajuan Izin Disetujui')
            ->greeting('Halo, ' . $notifiable->name)
            ->line('Pengajuan izin Anda untuk **' . $this->catatanKehadiran->jenisKehadiran->name . '** pada **' . ($startDate === $endDate ? $startDate : "$startDate - $endDate") . '** telah **disetujui**.')
            ->line('Keterangan: ' . ($this->catatanKehadiran->keterangan_izin ?: '-'))
            ->line('Terima kasih atas pengajuan Anda.')
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
