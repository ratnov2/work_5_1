<div x-data="historyContestData({{$history_contest_json}})" class=" h-48 bg-gray-800 bg-opacity-70 mx-auto w-full flex flex-col rounded-md shadow-md border border-gray-800 overflow-hidden">
    <div class="flex w-full h-full space-x-2">
        {{-- Item --}}
        <div class="flex flex-col items-center justify-center">
            @component('contest::elements.item', ['alpine__item' => 'history_contest.item'])@endcomponent
        </div>

        <div class="flex flex-grow flex-col items-start justify-center">
            {{-- Title --}}
            <template x-if="history_contest.type == 'default'">
                <div class="text-xs sm:text-sm flex space-x-2 items-center mt-2">
                    <i class="text-green-300 fad fa-gift"></i>
                    <p class="text-white">Бесплатный розыгрыш</p>
                </div>
            </template>
            <template x-if="history_contest.type == 'sponsor'">
                <div class="text-xs sm:text-sm flex space-x-2 items-center mt-2">
                    <i x-show="history_contest.type == 'sponsor'" class="text-orange-300 fas fa-crown"></i>
                    <p x-show="history_contest.type == 'sponsor'" class="text-white">Королевский розыгрыш</p>
                </div>
            </template>

            <template x-if="history_contest.win_player != null">
                <div class="flex justify-start items-center w-full h-full space-x-1">
                    <div class="transition-all duration-300 relative bg-center bg-cover bg-no-repeat w-10 h-10 rounded-lg border border-gray-700" :style="'background-image: url(' + history_contest.win_player.image +')'"></div>
                    <div class="flex flex-col -space-y-1.5">
                        <span class="text-white text-lg">Победитель:</span>
                        <span class="text-green-300 text-md" x-text="history_contest.win_player.name"></span>
                    </div>
                </div>
            </template>
            <template x-if="history_contest.win_player == null">
                <div class="w-full h-full flex items-center justify-center py-3 pr-3">
                    <x-banners.default class="rounded" title="Никто не принял участие в розыгрыше" color="indigo" />
                </div>
            </template>
        </div>
    </div>

    {{-- Timer and count players --}}
    <div class="bg-gray-800 bg-opacity-40 col-span-12 py-2 px-4 w-full justify-between items-center flex border-t border-gray-600">
        <div class="items-center flex space-x-2" :class="{
                'text-gray-200': history_contest.type == 'default',
                'text-orange-300': history_contest.type == 'sponsor',
            }"
        >
            <span class="text-sm"><i class="fas fa-clock"></i></span>
            <div class="flex items-center text-sm space-x-1">
                <span x-text="end_at"></span>
            </div>
        </div>
        <div class="space-x-2 flex items-center text-indigo-400">
            <span><i class="fas fa-users"></i></span>
            <span x-text="history_contest.count_players"></span>
        </div>
    </div>
</div>
