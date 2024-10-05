<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:data-collect')->everyFourMinutes();
Schedule::command('app:delete-link')->everyTenMinutes();
Schedule::command('app:delete-limit')->everyThirtyMinutes();

Schedule::command('app:process-emails')->everyFifteenSeconds();
Schedule::command('queue:work --stop-when-empty --tries=1')->everyFifteenSeconds();
Schedule::command('queue:retry all')->everyThirtyMinutes();
