<?php

namespace App\Console\Commands;

use App\Http\Controllers\mail\SendingEmailController;
use Illuminate\Console\Command;

class ProcessEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Current Time And Old Time Waiting All Emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $getEmails = new SendingEmailController();
        $addEmails = $getEmails->sendingEmails();

        $this->info($addEmails);
    }
}
