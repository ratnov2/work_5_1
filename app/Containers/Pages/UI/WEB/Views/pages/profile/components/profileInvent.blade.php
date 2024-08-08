<div x-data="profileInventData()" class="flex flex-col bg-gray-900 rounded-lg space-y-2 w-full h-full p-4">
    <div class="flex items-center flex-col sm:flex-row justify-center sm:justify-between">
        <p class="text-xl font-bold text-gray-100">Инвентарь</p>

        <span class="text-green-300 text-sm space-x-1">
            <span x-text="sumReadyItems"></span><x-icons.currency />
        </span>
    </div>

    <div class="ralative grid grid-cols-3 gap-0.5 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8">
        <template x-for="player_item in player_items" :key="player_item.uniqid">
            {{-- Item --}}
            <div :class="is_withdrawing || is_selling ? 'opacity-50' : 'opacity-100'" class="w-full h-28 transition duration-150 relative flex items-center justify-center rounded">
                <div class="z-20 absolute top-1 right-2 flex items-center space-x-1 text-[10px] text-green-300">
                    <span><span x-text="player_item.price"></span> <i class="fas fa-coin"></i></span>
                </div>

                {{-- Actions --}}
                <template x-if="player_item.status == ITEM_READY">
                    <div class="absolute z-20 bottom-4 w-auto flex items-center justify-center space-x-2">
                        <x-tooltip>
                            <x-slot name="icon">
                                <button class="h-6 w-6 text-md text-gray-900 rounded bg-indigo-300" @click="itemWithdraw(player_item.uniqid)">
                                    <i class="opacity-80 fas fa-arrow-alt-down"></i>
                                </button>
                            </x-slot>

                            <span>Вывести</span>
                        </x-tooltip>

                        <x-tooltip>
                            <x-slot name="icon">
                                <button class="h-6 w-6 text-md text-gray-900 rounded bg-green-300" @click="itemSell(player_item.uniqid)">
                                    <i class="opacity-80 fas fa-wallet"></i>
                                </button>
                            </x-slot>

                            <span>Продать</span>
                        </x-tooltip>
                    </div>
                </template>

                {{-- Status --}}
                <template x-if="player_item.status != ITEM_READY">
                    <span class="absolute z-30 right-1.5 top-5 w-auto flex flex-col items-center justify-center">
                        <template x-if="player_item.status == ITEM_SELLED">
                            <x-tooltip>
                                <x-slot name="icon">
                                    <x-badges.default color="green" size="small"><i class="text-sm fas fa-hand-holding-usd"></i></x-badges.default>
                                </x-slot>

                                <span>Предмет продан</span>
                            </x-tooltip>
                        </template>

                        <template x-if="player_item.status == ITEM_JACKPOT">
                            <x-tooltip>
                                <x-slot name="icon">
                                    <x-badges.default color="orange" size="small"><i class="text-sm fad fa-circle-notch"></i></x-badges.default>
                                </x-slot>

                                <span>Предмет поставлен в режим Джекпот</span>
                            </x-tooltip>
                        </template>

                        <template x-if="player_item.status == ITEM_MINES">
                            <x-tooltip>
                                <x-slot name="icon">
                                    <x-badges.default color="orange" size="small"><i class="text-sm fas fa-bomb"></i></x-badges.default>
                                </x-slot>

                                <span>Предмет поставлен в режим Мины</span>
                            </x-tooltip>
                        </template>

                        <template x-if="player_item.status == ITEM_UPGRADE">
                            <x-tooltip>
                                <x-slot name="icon">
                                    <x-badges.default color="orange" size="small"><i class="text-sm fad fa-chevron-double-up"></i></x-badges.default>
                                </x-slot>

                                <span>Предмет поставлен в режим Апгрейд</span>
                            </x-tooltip>
                        </template>

                        <template x-if="player_item.status == ITEM_TRADED">
                            <x-tooltip>
                                <x-slot name="icon">
                                    <x-badges.default color="indigo" size="small"><i class="text-sm fas fa-shipping-fast"></i></x-badges.default>
                                </x-slot>

                                <span>Предмет выведен</span>
                            </x-tooltip>
                        </template>

                        <template x-if="player_item.status == ITEM_TRADE_PROCCESSING">
                            <x-tooltip>
                                <x-slot name="icon">
                                    <x-badges.default color="indigo" size="small"><i class="text-sm fas fa-shipping-fast"></i></x-badges.default>
                                </x-slot>

                                <span>Предмет в процессе вывода</span>
                            </x-tooltip>
                        </template>
                    </span>
                </template>

                <div class="w-full h-full relative z-10">
                    @component('item::components.item-card', ['alpine__item' => 'player_item'])@endcomponent
                </div>
            </div>
        </template>

        <template x-if="player_items.length == 0 && !is_player_items_loading">
            <x-banners.default class="h-44 w-full col-span-3 sm:col-span-4 md:col-span-5 lg:col-span-6 xl:col-span-8 rounded-md" title="Предметы не найдены" desc="Покупайте или выигрывайте предметы и возвращайтесь за выводом" color="indigo" />
        </template>

        <x-buttons.actionable x-show="has_more_items" class="w-full h-28"
            @click="loadPlayerItems()"
            color="orange"
            size="normal"
            is-acting="is_player_items_loading"
            action="Еще"
        />
    </div>
</div>
