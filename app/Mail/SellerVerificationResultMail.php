<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SellerVerificationResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Seller $seller, public ?string $setPasswordUrl = null)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = $this->seller->status === Seller::STATUS_APPROVED
            ? 'Akun penjual Anda disetujui'
            : 'Registrasi penjual Anda ditolak';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.sellers.verification_result',
            with: [
                'seller' => $this->seller,
                'setPasswordUrl' => $this->setPasswordUrl,
            ],
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
