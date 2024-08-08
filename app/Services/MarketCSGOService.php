<?php

namespace App\Services;

use App\Containers\Settings\Tasks\GetSettingsApiKeyTask;
use App\Containers\Withdraw\DTO\MarketCSGOBuyForDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MarketCSGOService
{
    const SUCCESS_MARKET_STATUS = 2;
    const WAITING_MARKET_STATUS = 1;
    const ERROR_MARKET_STATUS = 5;

    public $settings_api_keys;

    public function __construct()
    {
        $this->settings_api_keys = app(GetSettingsApiKeyTask::class)->run();
    }

    public function getApiKey()
    {
        return $this->settings_api_keys->MARKET_API_KEY;
    }

    public function getBalance()
    {
        try {
            $data = Http::get("https://market.csgo.com/api/v2/get-money", [
                'key' => $this->getApiKey()
            ]);
            $csgotm_balance = ['currency' => 'RUB', 'value' => $data['money']];
        } catch (\Exception $ex) {
            $csgotm_balance = null;
        }
        return $csgotm_balance;
    }

    public function getTradesResult(array $custom_ids)
    {
        try {
            $market_api_key = $this->getApiKey();
            $custom_ids = '&custom_id[]=' . implode('&custom_id[]=', $custom_ids);
    
            $data = Http::get("https://market.csgo.com/api/v2/get-list-buy-info-by-custom-id?key=$market_api_key$custom_ids")->object();
            if (!$data->success) throw new \Exception($data->error);
    
            return $data;
        } catch (\Throwable $th) {
            Log::build(['driver' => 'single', 'path' => storage_path('logs/market-trades-list-error.log')])->info($th->getMessage());
            return null;
        }
    }

    public function buyFor(MarketCSGOBuyForDTO $buy_for_dto)
    {
        $params = $buy_for_dto->toArray();
        $params['key'] = $this->getApiKey();

        $data = Http::get("https://market.csgo.com/api/v2/buy-for", $params)->object();

        if (!$data->success) {
            $fail_msg = $this->getFailMsgFromData($data);
            Log::build(['driver' => 'single', 'path' => storage_path('logs/market-buy-for-error.log')])->info($data->error);
            return [
                'success' => false,
                'msg' => $fail_msg
            ];
        }

        return [
            'success' => true,
            'msg' => 'Успешное оформление заявки'
        ];
    }

    public function getFailMsgFromData($data)
    {
        $msg = "Ошибка оформления заявки на вывод!" . "\r\n" . "Попробуйте через 2 минуты!";
        if (
            strpos($data->error, "Ошибка проверки ссылки, наш бот не сможет забрать или передать вам вещи, проверьте возможность оффлайн трейдов на вашем аккаунте") !== false ||
            strpos($data->error, "Error verifying link. Our bot cannot take or transfer your items. Please check the function of offline trades on your account") !== false
        ) {
            $msg = "Ошибка проверки ссылки, наш бот не сможет забрать или передать вам вещи, проверьте возможность оффлайн трейдов на вашем аккаунте. \r\n Это значит, что у вас или Trade-бан или скрыт инвентарь.";
        } elseif (
            strpos($data->error, "Неверная ссылка для обмена") !== false
        ) {
            $msg = "Неверная ссылка для обмена." . "\r\n\r\n";
            $msg .= "ВНИМАНИЕ! Вам нужно сделать следующее:" . "\r\n";
            $msg .= "1. Создать новую Trade-ссылку в своем Steam профиле" . "\r\n";
            $msg .= "Создать ссылку можно здесь: http://steamcommunity.com/id/me/tradeoffers/privacy#trade_offer_access_url" . "\r\n\r\n";
            $msg .= "2. Обновить ее в нашем боте!" . "\r\n\r\n";
            $msg .= "Затем, вы можете заново запросить вывод предметов в своем профиле!";
        } elseif (
            strpos($data->error, "Не найден предмет по указанной цене или ниже") !== false ||
            strpos($data->error, "No item was found at the specified price or lower.") !== false ||
            strpos($data->error, "К сожалению, предложение устарело. Обновите страницу") !== false ||
            strpos($data->error, "Покупка данного предмета по такой цене невозможна") !== false
        ) {
            $msg = "Ошибка покупки и передачи вам предмета!" . "\r\n" . "Цена на данный предмет выросла!" . "\r\n" . "Вы можете попробовать вывести предмет позже или продать его и купить другой предмет в нашем магазине!";
        } elseif (
            strpos($data->error, "Недостаточно средств на счету") !== false ||
            strpos($data->error, "Not money") !== false
        ) {
            $msg = "У нас недостаточно средств для покупки и передачи вам скина! Скоро пополним баланс!" . "\r\n" . "Попробуйте через 1 час.";
        } elseif (
            strpos($data->error, "Вам нужно сначала открыть инвентарь в настройках стим профиля.") !== false
        ) {
            $msg = "Вам нужно сначала открыть инвентарь в настройках стим профиля.";
        } elseif (
            strpos($data->error, "Вы не можете покупать, так как не приняли слишком много предложений обмена") !== false ||
            strpos($data->error, "Ошибка сервера") !== false
        ) {
            $msg = "К сожалению, сервис вывода предметов перегружен." . "\r\n" . "Попробуйте через 1 час.";
        }
        return $msg;
    }
}
