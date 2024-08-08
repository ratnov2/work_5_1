<div x-data="jackpotData({{ $jackpot_json }})" class="flex flex-col items-center space-y-2">
    {{-- Top panel --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-2 w-full lg:h-[290px]">
        {{-- Chart --}}
        <div class="col-span-1 rounded-lg flex justify-center items-center overflow-hidden relative bg-gray-900 p-4">
            <div id="jackpot-chart" class="jackpot-chart flex flex-shrink-0 items-center justify-center relative z-10 rounded-full" style="width: 200px; height: 200px">
                {{-- Chart --}}
                <span class="w-full h-full relative z-10" x-html="chart_html"></span>
                {{-- Info status game --}}
                <div class="flex items-center justify-center absolute rounded-full z-20" style="width: 94%; height: 94%;">
                    <div class="flex flex-col items-center">
                        <template x-if="isShowWinPlayer">
                            <div class="flex flex-col space-y-1 items-center">
                                <div class="rounded-lg h-16 w-16 border-2 bg-gray-400 bg-cover bg-center bg-no-repeat" :style="{ backgroundImage: `url(${win_player.image})`, borderColor: `${win_player_info?.color}`}"></div>
                                <span class="text-xs text-gray-50" x-text="win_player.name"></span>
                            </div>
                        </template>

                        <template x-if="is_show_display">
                            <div style="font-family: 'a_LCDNova', sans-serif;" class="relative text-sm text-gray-100 flex items-center justify-center w-full">
                                <span class="z-10" x-text="display"></span>
                            </div>
                        </template>
                    </div>
                </div>
                {{-- Win player circle arrow --}}
                <div class="flex items-center justify-center absolute rounded-full border-2 border-gray-700 w-4/5 h-4/5 z-20" :style="`transition: all ${win_arrow_animation_ms}ms cubic-bezier(0, 0, 0, 1); transform: rotateZ(${win_arrow_rotation_deg}deg)`">
                    <span class="text-gray-300 text-4xl absolute -top-6"><i class="fas fa-caret-up"></i></span>
                </div>
            </div>
        </div>
        {{-- Bets --}}
        <div class="col-span-1 xl:col-span-2 overflow-y-auto pr-1">
            <template x-for="bet in jackpot.bets" :key="'jackpot.bets' + bet.id">
                <div class="mb-2">
                    @component('jackpot::bet.card', [
                        'alpine__bank' => 'bank',
                        'alpine__color' => 'players_info.find(player_info => player_info.player.id == bet.player.id)?.color',
                        'alpine__bet' => 'bet'
                    ])@endcomponent
                </div>
            </template>
            <template x-if="jackpot.bets.length == 0">
                <x-banners.default class="rounded-md" title="Ставок еще не было" desc="Станьте первым!" color="indigo" />
            </template>
        </div>
    </div>
    {{-- Round info --}}
    <div class="w-full h-16 flex justify-between rounded-lg overflow-hidden">
        <span class="h-full flex flex-col justify-center px-5 py-1 bg-gray-800 -space-y-0.5">
            <span x-show="jackpot.id != null" class="text-xs text-gray-300">Раунд</span>
            <span x-show="jackpot.id != null" class="text-md text-gray-50 flex flex-nowrap"> #<span x-text="jackpot.id"></span> </span>
            <span x-show="jackpot.id == null" class="text-xs text-gray-300">WAIT</span>
        </span>

        @component('jackpot::round.players', ['alpine__players_info' => 'roundPlayersInfo'])@endcomponent

        <div class="hidden sm:flex h-full">
            @component('jackpot::round.statistics.card', ['alpine__count_players' => 'countPlayers', 'alpine__count_items' => 'countItems', 'alpine__bank' => 'roundLikePHP(bank, 2)'])@endcomponent
        </div>
    </div>
    <div class="w-full h-12 flex justify-between sm:hidden rounded-lg overflow-hidden bg-gray-800">
        @component('jackpot::round.statistics.card', ['alpine__count_players' => 'countPlayers', 'alpine__count_items' => 'countItems', 'alpine__bank' => 'roundLikePHP(bank, 2)'])@endcomponent
    </div>
</div>
