<div x-data="jackpotHistoryData({{ $jackpots_history_json }})" class="w-full h-full bg-gray-900 flex flex-col space-y-1 rounded-md p-4 mt-2">
    <div class="flex items-center gap-2">
        <span class="text-xl text-gray-500 opacity-80"><i class="fas fa-history"></i></span>
        <span class="text-md text-white">История последних игр</span>
    </div>

    <div x-cloak class="flex flex-col items-center space-y-2 h-32 flex-grow overflow-y-auto pr-2">
        <template x-for="jackpot_history in jackpots_history" :key="'jackpots_history' + jackpot_history.round_id">
            <div class="bg-gray-800 rounded-md w-full items-center flex flex-nowrap">
                <div class="p-2 flex space-x-2 items-center flex flex-nowrap w-44 flex-shrink-0">
                    <div class="rounded-lg h-10 w-10 bg-gray-400 bg-cover bg-center bg-no-repeat" :style="'background-image: url(' + jackpot_history.win_player.image + ')'"></div>

                    <div class="inline-flex flex-col">
                        <span class="text-gray-50 text-md uppercase">#<span x-text="jackpot_history.round_id"></span> </span>
                        <span class="-mt-1 text-gray-300 text-xs uppercase">WIN TICKET #<span x-text="jackpot_history.win_ticket"></span></span>
                        <span class="-mt-1 text-green-300 text-sm uppercase"><span x-text="jackpot_history.win_precent"></span>%</span>
                    </div>
                </div>

                <div class="flex-grow overflow-x-auto h-full space-x-0.5 flex">
                    <template x-for="(jackpot_history_item, index) in jackpot_history.items" :key="'jackpot_history_items' + index">
                        <div class="w-28 h-full flex-shrink-0">
                            @component('item::components.item-card', ['alpine__item' => 'jackpot_history_item'])@endcomponent
                        </div>
                    </template>
                </div>
            </div>
        </template>

        <template x-if="jackpots_history.length == 0">
            <x-banners.default class="rounded-md" title="Игры не найдены" color="indigo" />
        </template>
    </div>
</div>
