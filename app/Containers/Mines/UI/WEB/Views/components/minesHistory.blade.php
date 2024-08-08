<div x-data="minesHistoryData()" class="h-full w-full p-4 rounded-md bg-gray-900 flex flex-col space-y-2">
    <div class="grid grid-cols-12 text-sm text-white border-b border-gray-700 pb-2">
        <div class="col-span-1 flex">
            <span>#</span>
        </div>
        <div class="col-span-3 flex">
            <span>Игрок</span>
        </div>
        <div class="col-span-6 flex">
            <span>Скины</span>
        </div>
        <div class="col-span-2 flex">
            <span>Выигрыш</span>
        </div>
    </div>

    <div class="flex flex-col flex-grow overflow-y-scroll overflow-x-hidden h-32 space-y-2">
        <template x-for="item in history" :key="'history' + item.id">
            <div class="rounded-lg grid grid-cols-12 gap-1 h-16">
                <div class="col-span-1 flex items-center">
                    <span class="text-white text-lg">#<span x-text="item.id"></span></span>
                </div>

                <div class="col-span-3 flex items-center space-x-2">
                    <div class="w-10 h-10 rounded bg-center bg-cover bg-no-repeat" :style="`background-image: url(${item.player.image})`"></div>
                    
                    <span class="text-white text-sm line-clamp-1 whitespace-nowrap text-ellipsis overflow-hidden" x-text="item.player.name"></span>
                </div>

                <div class="col-span-6 grid grid-cols-4 gap-2">
                    <div class="col-span-3 flex flex-nowrap overflow-x-auto items-center rounded-lg bg-gray-1000 px-1 py-0.5">
                        <template x-for="bet in item.bets" :key="'bet' + bet.id">
                            <img class="h-12 mr-0.5" :src="`https://cdn.csgo.com/item/${bet.item.market_hash_name}/150.png`" alt="item" onerror="this.onerror=null;this.src='/img/skin_mock.png'">
                        </template>
                    </div>

                    <div class="col-span-1 flex items-center space-x-1 text-sm text-white">
                        <x-icons.currency />
                        <span x-text="roundLikePHP(item.bets.reduce((acc, bet) => acc + parseFloat(bet.price), 0), 2)"></span>
                    </div>
                </div>

                <div class="col-span-2 flex">
                    <template x-if="item.win_amount != null">
                        <div class="flex items-center space-x-1 text-sm text-green-300">
                            <x-icons.currency />
                            <span x-text="item.win_amount"></span>
                        </div>
                    </template>

                    <template x-if="item.win_amount == null">
                        <div class="flex items-center space-x-1 text-sm text-red-300">
                            <span>Проигрыш</span>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>
</div>