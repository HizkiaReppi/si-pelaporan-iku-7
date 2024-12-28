<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportUpdatedNotification extends Notification
{
    use Queueable;

    public $pelaporan;

    /**
     * Create a new notification instance.
     */
    public function __construct($pelaporan)
    {
        $this->pelaporan = $pelaporan;
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
        return (new MailMessage())
            ->subject('Laporan Mata Kuliah ' . $this->pelaporan->mataKuliah->name . ' Diperbarui')
            ->view('mail.prodi-report-updated', [
                'pelaporan' => $this->pelaporan,
            ]);
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
