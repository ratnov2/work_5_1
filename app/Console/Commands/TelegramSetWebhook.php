<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TelegramSetWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set telegram webhook for bot';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $telegram_token = config('services.telegram.token');

        $response = Http::post("https://api.telegram.org/bot{$telegram_token}/setWebhook", [
            'url' => route('telegram.webhook')
        ]);

        if($response->ok()) {
            echo 'Good!';
        } else {
            echo 'Что-то пошло не так...';
        }
    }
}
