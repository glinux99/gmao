<?php

use App\Console\Commands\RepportSend;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();
// Schedule ::command('repport:send')->weekly()->wednesdays()->at('12:00');
Schedule::command('app:check-task')->everyMinute();
Schedule::command('maintenance:check-schedule')->dailyAt('08:00');


// ->weekly();

