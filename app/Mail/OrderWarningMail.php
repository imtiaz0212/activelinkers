<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderWarningMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoiceInfo;
    public $orderInfo;
    public $emailFrom;

    /**
     * Create a new message instance.
     */
    public function __construct($invoiceInfo, $orderInfo, $emailFrom = null)
    {
        $this->invoiceInfo = $invoiceInfo;
        $this->orderInfo = $orderInfo;
        $this->emailFrom   = (!empty($emailFrom) ? $emailFrom : config('app.mail_from_address'));
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address($this->emailFrom, getSiteInfo()->site_name),
            subject: 'Warning Invocie',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.warning-invoice',
            with: ['invoiceInfo' => $this->invoiceInfo, 'orderInfo' => $this->orderInfo]
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
