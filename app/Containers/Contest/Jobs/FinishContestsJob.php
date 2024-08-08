<?php

namespace App\Containers\Contest\Jobs;

use App\Containers\Contest\Actions\FinishContestsAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FinishContestsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            app(FinishContestsAction::class)->run();
        } catch (\Throwable $th) {
            $this->fail($th);
        }
    }
}
