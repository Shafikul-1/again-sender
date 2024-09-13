<?php

namespace App\Console\Commands;

use App\Http\Controllers\mail\SendingEmailController;
use Illuminate\Console\Command;

class CheckTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-time';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Email Send Time Because Problem any internet or electrity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $checkTime = new SendingEmailController();
        $checking = $checkTime->checkTime();
        $this->info($checking);
    }
}
