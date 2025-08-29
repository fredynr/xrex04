<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class MailDeliveryEstudio extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $bodyText;
    public $adjuntos;

    public function __construct($subjectLine, $bodyText, $adjuntos)
    {
        $this->subjectLine = $subjectLine;
        $this->bodyText = $bodyText;
        $this->adjuntos = $adjuntos;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.layoutMailDeliveryEstudio',
            with: [
                'bodyText' => $this->bodyText,
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
        return collect($this->adjuntos)->map(function ($path) {
            return Attachment::fromPath($path)
                ->as(basename($path))
                ->withMime('image/jpeg');
        })->toArray();
    }
}
