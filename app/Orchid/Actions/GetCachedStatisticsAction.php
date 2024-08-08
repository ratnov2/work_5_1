<?php

namespace App\Orchid\Actions;

use App\Containers\BoxUnique\Models\Box;
use App\Containers\Jackpot\Models\Jackpot;
use App\Containers\Mines\Models\MinesGame;
use App\Containers\PaymentSection\Payment\Models\Payment;
use App\Containers\Player\Data\Types\PlayerItemStatus;
use App\Containers\Player\Models\Player;
use App\Containers\Player\Models\PlayerItem;
use App\Containers\Trade\Models\Trade;
use App\Containers\Upgrade\Models\Upgrade;
use App\Services\MarketCSGOService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GetCachedStatisticsAction
{
    public function run() : array
    {
        return Cache::remember('admin-statistics', 60, function() {
            $count_players = Player::default()->count();

            $sum_players_balance = round(Player::default()->sum('balance'), 2);
            $sum_players_items = round(PlayerItem::whereNotIn('player_id', Player::employee()->pluck('id')->toArray())->where('status', PlayerItemStatus::Ready)->sum('price'), 2);

            $sum_profit_jackpots = round(Jackpot::end()->sum('profit'), 2);
            $sum_profit_upgrades = round(Upgrade::sum('profit'), 2);
            $sum_profit_mines = round(PlayerItem::minesed()->sum('price') - MinesGame::sum('win_amount'), 2);

            $sum_payments = round(Payment::success()->sum('sum'), 2);
            $sum_trades = round(Trade::sum('paid'), 2);

            $market_csgo_service = app(MarketCSGOService::class);
            $csgotm_balance = $market_csgo_service->getBalance();
            $csgotm_balance = is_null($csgotm_balance) ? 'Ошибка получения баланса' :  $csgotm_balance['value'] . ' РУБ';

            $avg_payment_player = $count_players > 0 ? round($sum_payments / $count_players, 2) : 0;

            $groups_statistics_cards['По игровым режимам'] = [
                [
                    'title' => 'Профит JACKPOT',
                    'value' => $sum_profit_jackpots . ' РУБ',
                ],
                [
                    'title' => 'Профит UPGRADE',
                    'value' => $sum_profit_upgrades . ' РУБ',
                ],
                [
                    'title' => 'Профит MINES',
                    'value' => $sum_profit_mines . ' РУБ',
                ],
            ];

            $groups_statistics_cards['По пополнениям'] = [
                [
                    'title' => 'Всего пополнено',
                    'value' => $sum_payments . ' РУБ',
                ],
                [
                    'title' => 'Средний платеж (1 игрок)',
                    'value' => $avg_payment_player . ' РУБ',
                ],
            ];

            $groups_statistics_cards['По выводам'] = [
                [
                    'title' => 'Потрачено на вывод',
                    'value' => $sum_trades . " РУБ",
                ],
                [
                    'title' => 'Баланс CSGO TM',
                    'value' => $csgotm_balance,
                ],
            ];

            $groups_statistics_cards['По игрокам'] = [
                [
                    'title' => 'Кол-во игроков',
                    'value' => $count_players,
                ],
                [
                    'title' => 'Сумма балансов обычных игроков',
                    'value' => $sum_players_balance . " РУБ",
                ],
                [
                    'title' => 'Сумма предметов обычных игроков',
                    'value' => $sum_players_items . " РУБ",
                ],
            ];

            return [
                'payments_chart_data' => $this->getPaymentsChartData(),
                'box_chart_data' => $this->getBoxChartData(),
                'groups_statistics_cards' => $groups_statistics_cards,
            ];
        });
    }

    private function getBoxChartData()
    {
        $box_promocodable = Box::promocodable()->first();
        $box_timerable = Box::timerable()->first();

        $box_promocodable_count = DB::table('item_player')->where([['dropable_type', Box::class], ['dropable_id', $box_promocodable->id]])->whereDate('created_at', '>=', \Carbon\Carbon::now()->subMonth())
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $box_promocodable_chart_data = ['labels' => [], 'name'  => 'Кейс за промокод', 'values' => []];

        $box_timerable_count = DB::table('item_player')->where([['dropable_type', Box::class], ['dropable_id', $box_timerable->id]])->whereDate('created_at', '>=', \Carbon\Carbon::now()->subMonth())
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        $box_timerable_chart_data = ['labels' => [], 'name'  => 'Кейс по таймеру', 'values' => []];

        // Формирование графиков
        $period = \Carbon\CarbonPeriod::create(\Carbon\Carbon::now()->startOfMonth(), \Carbon\Carbon::now()->endOfMonth());
        foreach ($period as $date) {
            $date = $date->format('Y-m-d');
            $box_promocodable_chart_data['labels'][] = $date;
            $box_promocodable_chart_data['values'][] = isset($box_promocodable_count[$date]) ? $box_promocodable_count[$date] : 0;

            $box_timerable_chart_data['labels'][] = $date;
            $box_timerable_chart_data['values'][] = isset($box_timerable_count[$date]) ? $box_timerable_count[$date] : 0;
        }

        return [$box_promocodable_chart_data, $box_timerable_chart_data];
    }

    private function getPaymentsChartData()
    {
        // Успешные платежи
        $payments_success = Payment::whereDate('created_at', '>=', \Carbon\Carbon::now()->subMonth())
            ->success()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(sum) as sum'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('sum', 'date');

        $payments_success_chart_data = ['labels' => [], 'name'  => 'Payments', 'values' => []];

        // Выводы предметов
        $trades_success = Trade::whereDate('created_at', '>=', \Carbon\Carbon::now()->subMonth())
            ->success()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(paid) as paid'))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('paid', 'date');

        $trades_success_chart_data = ['labels' => [], 'name'  => 'Trades', 'values' => []];

        // Формирование графиков
        $period = \Carbon\CarbonPeriod::create(\Carbon\Carbon::now()->startOfMonth(), \Carbon\Carbon::now()->endOfMonth());
        foreach ($period as $date) {
            $date = $date->format('Y-m-d');
            $payments_success_chart_data['labels'][] = $date;
            $payments_success_chart_data['values'][] = isset($payments_success[$date]) ? $payments_success[$date] : 0;

            $trades_success_chart_data['labels'][] = $date;
            $trades_success_chart_data['values'][] = isset($trades_success[$date]) ? $trades_success[$date] : 0;
        }

        return [$payments_success_chart_data, $trades_success_chart_data];
    }
}
