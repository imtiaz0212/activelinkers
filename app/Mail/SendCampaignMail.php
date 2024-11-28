<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendCampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    public $emailFrom;

    /**
     * Create a new message instance.
     */
    public function __construct($data, $emailFrom)
    {
        $this->data      = $data;
        $this->emailFrom = $emailFrom;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->emailFrom, getSiteInfo()->site_name),
            subject: $this->data->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.campaign',
                 with: ['data' => $this->data]
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
