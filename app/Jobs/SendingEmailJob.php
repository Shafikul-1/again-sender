<?php

namespace App\Jobs;

use Throwable;
use App\Models\MailSetup;
use App\Models\SendingEmail;
use App\Mail\SendingEmailMail;
use App\Models\MailContent;
use App\Models\MailDelivaryDetail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\MailManager;
use Illuminate\Support\Facades\Cache;

class SendingEmailJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels, Dispatchable;

    protected $sendingEmails;
    protected $originalMailConfig;

    /**
     * Create a new job instance.
     */
    public function __construct($sendingEmails)
    {
        $this->sendingEmails = $sendingEmails;
        $this->originalMailConfig = config('mail');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->sendingEmails as $emails) {

            $lockKey = 'email_job_lock_' . $emails->id;
            if(Cache::has($lockKey)){
                Log::info("Email job is already running for ID: " . $emails->id);
                continue;
            }
            Cache::put($lockKey, true, 420);

            $status = false;

            $againCheck = $this->checkDublicate($emails);
            if ($againCheck) {
                Log::info("dublicate " . $emails->mails);
                continue;
            }

            $mailConfigData = $this->setupConfig($emails);
            if (!$mailConfigData) {
                SendingEmail::where('id', $emails->id)->update(['status' => 'fail']);
                continue;
            }

            $mailContent = MailContent::find($emails->mail_content_id);
            $senderDefultData = [
                'mail_sender_name' => $mailConfigData->mail_sender_name,
                'mail_from' => $mailConfigData->mail_from,
                'sender_number' => $mailConfigData->sender_number,
                'sender_website' => $mailConfigData->sender_website,
                'sender_department' => $mailConfigData->sender_department,
                'sender_company_logo' => $mailConfigData->sender_company_logo,
            ];
            try {
                Mail::to($emails->mails)->send(new SendingEmailMail($mailContent, $senderDefultData, $mailConfigData->other_links));

                $status = true;
            } catch (Throwable $e) {
                $status = false;
                Log::error('Queue Work Error => ' . $e->getMessage());
            } finally{
                Cache::forget($lockKey);
            }

            // // // Log END config
            // Log::info('__END__ ', [
            //     'To' => $emails->mails,
            //     'mailAddress' => config('mail.from.address'),
            //     'mailMailersUsername' => config('mail.mailers.' . $mailConfigData->mail_transport . '.username'),
            // ]);

            config(['mail' => $this->originalMailConfig]);
            SendingEmail::where('id', $emails->id)->update(['status' => $status ? 'success' : 'fail']);
        }
    }

    // Check mail status same mail is Exists?
    private function checkDublicate($emails)
    {
        return SendingEmail::where('mails', $emails->mails)
            ->where('mail_form', $emails->mail_form)
            ->whereIn('status', ['success', 'processing'])
            ->where('send_time', $emails->send_time)
            ->where('user_id', $emails->user_id)
            ->exists();
    }

    // Mail Config Setup
    private function setupConfig($emails)
    {
        $mailConfigData = MailSetup::find($emails->mailsetup_id);

        // Log::info('--BEFORE--', [
        //     'To' => $emails->mails,
        //     'mailAddress' => config('mail.from.address'),
        //     'mailMailersUsername' => config('mail.mailers.' . $mailConfigData->mail_transport . '.username'),
        // ]);

        try {
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

            // Email Config Refresh
            app()->make(MailManager::class)->forgetMailers();
            // Log::info('<<AFTER try>>', [
            //     'To' => $emails->mails,
            //     'mailAddress' => config('mail.from.address'),
            //     'mailMailersUsername' => config('mail.mailers.' . $mailConfigData->mail_transport . '.username'),
            // ]);

            SendingEmail::where('id', $emails->id)->update(['status' => 'processing']);
            return $mailConfigData;

        } catch (\Throwable $th) {
            Log::info('<<AFTER catch>>', [
                'To' => $emails->mails,
                'mailAddress' => config('mail.from.address'),
                'mailMailersUsername' => config('mail.mailers.' . $mailConfigData->mail_transport . '.username'),
            ]);
            return false;
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
        Log::error('Email job failed: ' . $exception->getMessage());

        foreach ($this->sendingEmails as $emails) {
            SendingEmail::where('id', $emails->id)->where('status', 'pending')->update(['status' => 'fail']);
        }
    }
}
