<?php

namespace App\Jobs;

use Throwable;
use App\Models\MailSetup;
use App\Models\SendingEmail;
use App\Mail\SendingEmailMail;
use App\Models\MailDelivaryDetail;
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
            $mailConfigData = MailSetup::find($emails->mailsetup_id);

            $originalMailConfig = config('mail');

            config([
                'mail.default' => $mailConfigData->mail_transport,
                'mail.mailers.' . $mailConfigData->mail_transport => [
                    'transport' => $mailConfigData->mail_transport,
                    'host' => $mailConfigData->mail_host,
                    'port' => $mailConfigData->mail_port,
                    'username' => $mailConfigData->mail_username,
                    'password' => $mailConfigData->mail_password,
                    'encryption' => $mailConfigData->mail_encryption,
                ],
                'mail.from' => [
                    'address' => $mailConfigData->mail_from,
                    'name' => $mailConfigData->mail_sender_name,
                ],
            ]);

            $status = false;
            try {
                $senderDefultData = [
                    'mail_sender_name' => $mailConfigData->mail_sender_name,
                    'mail_from' => $mailConfigData->mail_from,
                    'sender_number' => $mailConfigData->sender_number,
                    'sender_website' => $mailConfigData->sender_website,
                    'sender_department' => $mailConfigData->sender_department,
                    'sender_company_logo' => $mailConfigData->sender_company_logo,
                ];
                Mail::to($emails->mails)->send(new SendingEmailMail($emails->mail_content[0], $senderDefultData, $mailConfigData->other_links));
                $status = true;
            } catch (Throwable $e) {
                $status = false;
                Log::error('Queue Work Error => ' . $e->getMessage());
            }

            config(['mail' => $originalMailConfig]);

            SendingEmail::where('id', $emails->id)->update(['status' => $status ? 'success' : 'fail']);
        }
    }
}
