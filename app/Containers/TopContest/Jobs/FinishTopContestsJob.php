<?php

namespace App\Containers\TopContest\Jobs;

use App\Containers\TopContest\Actions\FinishTopContestsAction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FinishTopContestsJob implements ShouldQueue
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
            app(FinishTopContestsAction::class)->run();
        } catch (\Throwable $th) {
            $this->fail($th);
        }
    }
}

