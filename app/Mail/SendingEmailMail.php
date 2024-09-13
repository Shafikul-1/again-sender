<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendingEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sending_email_data;
    public $mail_sender_name;
    public $mail_from;
    public $sender_number;
    public $sender_website;
    public $other_links;
    /**
     * Create a new message instance.
     */
    public function __construct($sending_email_data, $mail_sender_name, $mail_from, $sender_number, $sender_website, $other_links)
    {
        $this->sending_email_data = $sending_email_data;
        $this->mail_sender_name = $mail_sender_name;
        $this->mail_from = $mail_from;
        $this->sender_number = $sender_number;
        $this->sender_website = $sender_website;
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
