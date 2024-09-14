<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendingEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sending_email_data;
    public $senderDefultData;
    public $other_links;
    /**
     * Create a new message instance.
     */
    public function __construct($mailContent, $senderDefultData, $other_links)
    {
        $this->sending_email_data = $mailContent;
        $this->senderDefultData = $senderDefultData;
        $this->other_links = $other_links;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->sending_email_data->mail_subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.template',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachMent = [];

        foreach($this->sending_email_data->mail_files as $files){
            $filePath = public_path('mailFile/' . $files);
            if(file_exists($filePath)){
                $attachMent[] = $filePath;
            }
        }

        return $attachMent;
    }
}
