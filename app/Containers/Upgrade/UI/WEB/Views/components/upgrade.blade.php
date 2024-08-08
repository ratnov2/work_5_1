<div x-data="upgradeData()" class="w-full h-full flex flex-col items-center space-y-2">
    @include('upgrade::elements.platform')
    {{-- Items --}}
    <template x-if="$store.player.player !== null">
        <div x-data="searchItemsData()" class="h-[200px] flex-grow flex flex-col w-full bg-gray-900 py-5 pl-5 pr-2.5 rounded-md space-y-2">
            {{-- Top panel --}}
            <div class="flex gap-2 justify-between">
                <div class="hidden md:flex items-center gap-2">
                    <span class="text-xl text-gray-500 opacity-80"><i class="fad fa-chevron-double-up"></i></span>
                    <span class="text-md text-white">Скины</span>
                </div>

                <div class="grid grid-cols-3 gap-1">
                    <input x-model="name" @input="search_items = []; is_loading_items = true" @input.debounce.1000ms="loadClearItems" class="text-xs text-gray-100 w-full input-default" id="search" placeholder="Название" type="text">
                    <input x-model="price" @input="search_items = []; is_loading_items = true" @input.debounce.1000ms="loadClearItems" class="text-xs text-gray-100 w-full input-default" id="price" placeholder="Цена" type="number" step="0.01">

                    {{-- Input raritets --}}
                    <div class="w-full relative" x-data="{ is_open: false }">
                        <button @click="is_open = !is_open" class="text-xs text-gray-100 w-full input-default">
                            <span>Редкость</span>
                            <i x-show="!is_open" class="fas fa-chevron-down"></i>
                            <i x-show="is_open" class="fas fa-chevron-up"></i>
                        </button>

                        <div @click="search_items = []; is_loading_items = true" @click.debounce.1000ms="loadClearItems"
                            @click.away="is_open = false"
                            class="text-xs absolute z-50 grid grid-cols-4 gap-2 top-12 shadow-xl p-2 bg-gray-800 rounded-md"
                            style="box-shadow: 0 0 10px 5px #1a1820;"
                            x-show="is_open"
                        >
                            <template x-for="rarity in Object.keys(rarities)">
                                <button @click="rarities[rarity] = !rarities[rarity]" class="w-5 h-5 rounded-md flex items-center justify-center"
                                    :class="{
                                        'bg-opacity-30': !rarities[rarity],
                                        'bg-gray-400': rarity == 'common',
                                        'bg-cyan-600': rarity == 'uncommon',
                                        'bg-indigo-600': rarity == 'milspec',
                                        'bg-purple-600': rarity == 'restricted',
                                        'bg-pink-600': rarity == 'classified',
                                        'bg-red-600': rarity == 'covert',
                                        'bg-yellow-600': rarity == 'rare',
                                    }"
                                >
                                    <span x-show="!rarities[rarity]" class="text-sm text-white"><i class="fas fa-times"></i></span>
                                    <span x-show="rarities[rarity]" class="text-sm text-white"><i class="fas fa-check"></i></span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Items list --}}
            <div class="flex-grow overflow-y-scroll pr-2.5">
                <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-1">
                    {{-- Search item --}}
                    <template x-for="(search_item, index) in search_items" :key="'search_items' + search_item.market_hash_name + index">
                        <button @click="selectWantedItem(search_item)" class="flex relative h-24">
                            <span class="z-30 absolute top-1 right-2 flex items-center space-x-1 text-[10px] text-green-300"><span x-text="search_item.price"></span> <i class="fas fa-coin"></i></span>
                            @component('item::elements.check-item', ['alpine__is_show' => 'wanted_item == search_item'])@endcomponent
                            @component('item::components.item-card', ['alpine__item' => 'search_item'])@endcomponent
                        </button>
                    </template>

                    <x-buttons.actionable @click="loadMoreItems()"
                        class="h-24"
                        color="orange"
                        is-acting="is_loading_items"
                        action='<i class="fas fa-plus"></i> Еще'
                    />
                </div>

                <template x-if="is_show_not_found_items">
                    <x-banners.default class="rounded-md" title="Предметы не найдены" desc="Попробуйте изменить параметры поиска" color="red" />
                </template>
            </div>
        </div>
    </template>

    {{-- No auth --}}
    <template x-if="$store.player.player === null">
        <div class="relative w-full h-full rounded-lg flex flex-col items-center justify-center">
            <span class="absolute opacity-20 text-[120px]"><i class="fad fa-chevron-double-up"></i></span>
            <x-banners.auth />
        </div>
    </template>
</div>
