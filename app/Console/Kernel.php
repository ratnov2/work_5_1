<?php

namespace App\Console;

use App\Containers\Contest\Jobs\StartContestsJob;
use App\Containers\Contest\Jobs\FinishContestsJob;
use App\Containers\Item\Jobs\UpdateItemsJob;
use App\Containers\Trade\Jobs\MarketCSGOCheckTradesJob;
use App\Containers\TopContest\Jobs\FinishTopContestsJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Queue;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function() {
            if(Queue::size('update_items') == 0) UpdateItemsJob::dispatch()->onQueue('update_items');
            FinishTopContestsJob::dispatch();
            FinishContestsJob::dispatch();
        })->everyTwoMinutes();

        $schedule->call(function() {
            if(Queue::size('check_trades') == 0) MarketCSGOCheckTradesJob::dispatch()->onQueue('check_trades');
        })->everyMinute();

        $schedule->call(function () {
            StartContestsJob::dispatch();
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
