<?php

namespace App\Mail;

use App\Models\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    private string $one_time_password;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $one_time_password)
    {
        $this->user = $user;
        $this->one_time_password = $one_time_password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '2FA Verification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.2faVerification',
            with: [
                'email' => $this->user->email,
                'code' => $this->one_time_password,
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
