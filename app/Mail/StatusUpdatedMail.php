<?php

namespace App\Mail;

use App\Models\IKU7;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public IKU7 $daftarPelaporan;

    /**
     * Create a new message instance.
     */
    public function __construct(IKU7 $daftarPelaporan)
    {
        $this->daftarPelaporan = $daftarPelaporan->load(['user', 'prodi', 'periode', 'mataKuliah']);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pembaruan Status Verifikasi Mata Kuliah ' . $this->daftarPelaporan->mataKuliah->name,
            tags: ['mata_kuliah', 'iku'],
            metadata: [
                'id' => $this->daftarPelaporan->id
            ]
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.courses-status-updated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
