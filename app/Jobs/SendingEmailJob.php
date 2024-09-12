<?php

namespace App\Jobs;

use Throwable;
use App\Models\MailSetup;
use App\Mail\SendingEmailMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendingEmailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels, Dispatchable;

    protected $sendingEmails;
    /**
     * Create a new job instance.
     */
    public function __construct($sendingEmails)
    {
        $this->sendingEmails = $sendingEmails;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->sendingEmails as $emails) {
            $mailConfigData = MailSetup::where('mail_username', $emails->mail_form)->first();
            config([
                'mail.default' => $mailConfigData->mail_transport, // ডাইনামিক ভাবে transport সেট হচ্ছে
                'mail.mailers.' . $mailConfigData->mail_transport => [
                    'transport' => $mailConfigData->mail_transport,
                    'host' => $mailConfigData->mail_host,
                    'port' => $mailConfigData->mail_port,
                    'username' => $mailConfigData->mail_username,
                    'password' => $mailConfigData->mail_password,
                    'encryption' => $mailConfigData->mail_encryption,
                ],
                'mail.form.' => [
                    'address' => $mailConfigData->mail_from,
                    'name' => 'Yousuf Ali',
                ],
            ]);

            try{
                Mail::to($emails->mails)->send(new SendingEmailMail($emails->mail_content[0]));
            } catch(Throwable $e){
                Log::error('Queue Work Error => ' . $e->getMessage());
            }
        }
    }
}
