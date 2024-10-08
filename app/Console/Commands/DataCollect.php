<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\fbData\CollectDataController;

class DataCollect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:data-collect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $collecting = new CollectDataController();

        // Just Show return Message
        $getData = $collecting->collectData();
        $this->info($getData);

        // Only Message Return Show
        $storeData = $collecting->reciveData();
        $this->info($storeData);


        return 0;
    }
}
