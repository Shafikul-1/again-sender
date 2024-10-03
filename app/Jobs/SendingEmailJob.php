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
use Illuminate\Mail\MailManager;

class SendingEmailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels, Dispatchable;

    public $tries = 3;
    public $retryAfter = 20;
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

            // IF Job Fail then again check
            $againCheck = SendingEmail::where('mails', $emails->mails)->where('mail_form', $emails->mail_form)->where('status', 'success')->where('send_time', $emails->send_time)->where('user_id', $emails->user_id)->exists();
            if($againCheck){
                continue;
            }

            $mailConfigData = MailSetup::find($emails->mailsetup_id);
            $originalMailConfig = config('mail');

            // Log BEFORE config
            Log::info('Email check - BEFORE config', [
                'To' => $emails->mails,
                'mailAddress' => config('mail.from.address'),
                'mailMailersUsername' => config('mail.mailers.' . $mailConfigData->mail_transport . '.username'),
            ]);

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

            // Email Configer Reset
            app()->make(MailManager::class)->forgetMailers();

            Log::info('Email check - AFTER config', [
                'To' => $emails->mails,
                'mailAddress' => config('mail.from.address'),
                'mailMailersUsername' => config('mail.mailers.' . $mailConfigData->mail_transport . '.username'),
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

            // Log END config
            Log::info('Email check - END config', [
                'To' => $emails->mails,
                'mailAddress' => config('mail.from.address'),
                'mailMailersUsername' => config('mail.mailers.' . $mailConfigData->mail_transport . '.username'),
            ]);

            config(['mail' => $originalMailConfig]);
            SendingEmail::where('id', $emails->id)->update(['status' => $status ? 'success' : 'fail']);
        }
    }

    /**
     * Handle a job failure.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        // Log::error('Email job failed: ' . $exception->getMessage());

        foreach ($this->sendingEmails as $emails) {
            SendingEmail::where('id', $emails->id)->where('status', 'pending')->update(['status' => 'fail']);
        }
    }
}
