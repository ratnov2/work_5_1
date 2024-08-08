<div @click.stop x-data="shopData()" class="bg-gray-900 shadow-xl w-full sm:w-96 rounded-md overflow-hidden h-full flex flex-col p-2">
    <div x-data="searchItemsData()" class="flex flex-col flex-grow space-y-2">
        <p class="text-xl text-white">Выберите скины</p>

        <div class="grid grid-cols-3 gap-1">
            <div class="bg-gray-800 flex flex-col -space-y-0.5 flex p-2 justify-center rounded-tl-md rounded-bl-md">
                <span class="text-green-300 text-sm flex flex-nowrap gap-1"><span x-text="sumWillGive"></span><x-icons.currency /></span>
                <span class="uppercase text-xs text-gray-300">отдаете</span>
            </div>

            <div class="bg-gray-800 flex flex-col -space-y-0.5 flex p-2 justify-center">
                <span class="text-white text-sm flex flex-nowrap gap-1"><span x-text="sumSelected"></span><x-icons.currency /></span>
                <span class="uppercase text-xs text-gray-300">выбрано</span>
            </div>

            <div class="bg-gray-800 flex flex-col -space-y-0.5 flex p-2 justify-center rounded-tr-md rounded-br-md">
                <span class="text-white text-sm flex flex-nowrap gap-1"><span x-text="sumWillStay"></span><x-icons.currency /></span>
                <span class="uppercase text-xs text-gray-300">останется</span>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-1">
            <input x-model="name" @input="search_items = []; is_loading_items = true" @input.debounce.1000ms="loadClearItems" class="text-xs text-gray-100 w-full input-default" id="search" placeholder="Название" type="text">

            <input x-model="price" @input="search_items = []; is_loading_items = true" @input.debounce.1000ms="loadClearItems" class="text-xs text-gray-100 w-full input-default" id="price" placeholder="Цена" type="number" step="0.01">

            <div class="w-full relative" x-data="{ is_open_rarities: false }">
                <button @click="is_open_rarities = !is_open_rarities" class="text-xs text-gray-100 w-full input-default flex items-center flex-nowrap gap-1">
                    <span>Редкость</span>
                    <i x-show="!is_open_rarities" class="fas fa-chevron-down"></i>
                    <i x-show="is_open_rarities" class="fas fa-chevron-up"></i>
                </button>

                <div @click="search_items = []; is_loading_items = true" @click.debounce.1000ms="loadClearItems"
                    @click.away="is_open_rarities = false"
                    class="text-xs absolute z-50 grid grid-cols-4 gap-2 top-12 shadow-xl p-2 bg-gray-800 rounded-md"
                    style="box-shadow: 0 0 10px 5px #1a1820;"
                    x-show="is_open_rarities"
                >
                    <template x-for="rarity in Object.keys(rarities)">
                        <button @click="rarities[rarity] = !rarities[rarity]"
                            class="w-5 h-5 rounded-md flex items-center justify-center"
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
        <div class="h-48 flex-grow overflow-y-auto pr-1">
            <div class="grid grid-cols-3 gap-1">
                <template x-for="(search_item, index) in search_items" :key="'search_items' + search_item.market_hash_name + index">
                    <div class="relative overflow-hidden">
                        <template x-if="selectedShopItemsWithQuantity.find(item => item.market_hash_name === search_item.market_hash_name)">
                            <div class="absolute z-10 h-full w-full bg-gray-900 bg-opacity-90 flex items-center justify-between p-3">
                                <button class="text-red-500 text-2xl" @click="removeShopItem(search_item)"><i class="fas fa-minus"></i></button>
                                <span class="text-white text-2xl" x-text="selectedShopItemsWithQuantity.find(item => item.market_hash_name === search_item.market_hash_name)?.quantity"></span>
                                <button class="text-green-300 text-2xl" @click="addShopItem(search_item)"><i class="fas fa-plus"></i></button>
                            </div>
                        </template>

                        <button @click="addShopItem(search_item)" x-show="!selectedShopItemsWithQuantity.find(item => item.market_hash_name === search_item.market_hash_name)" class="absolute z-10 h-full w-full"></button>

                        <div class="relative z-0 h-full">
                            {{-- Item --}}
                            <div class="w-full h-24 relative flex items-center justify-center overflow-hidden">
                                <div class="z-10 absolute top-1 right-2 flex items-center space-x-1 text-[10px] text-green-300">
                                    <span><span x-text="search_item.price"></span> <i class="fas fa-coin"></i></span>
                                </div>
                                @component('item::components.item-card', ['alpine__item' => 'search_item'])@endcomponent
                            </div>
                        </div>
                    </div>
                </template>

                <x-buttons.actionable @click="loadMoreItems()"
                    x-show="!is_show_not_found_items"
                    class="w-full h-24"
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

    <div class="flex gap-2 mt-2">
        <x-buttons.actionable @click="accept()"
            color="green"
            class="flex-grow"
            is-disabled="!isShowAcceptButton"
            is-acting="is_accepting"
            action='<i class="fas fa-check"></i> Подтвердить'
        />

        <x-buttons.default @click="removeShopItems()"
            color="red"
            ::disabled="selected_shop_items.length == 0"
            ::class="selected_shop_items.length != 0 ? 'opacity-100 grayscale-0' : 'opacity-20 grayscale'"
        >
            <i class="fas fa-trash"></i>
        </x-buttons.default>
    </div>
</div>
