<div x-data="inventData()" class="relative flex flex-col bg-gray-900 rounded-lg p-2 h-full">
    <div class="flex items-center justify-between">
        <p class="text-lg font-bold text-gray-100">Доступные предметы</p>
    </div>

    <div class="flex-grow mt-2 overflow-y-auto bg-gray-900 bg-opacity-50">
        <div class="grid grid-cols-3 gap-0.5 items-start pr-1">
            <template x-for="player_item in player_items" :key="'player_items' + player_item.uniqid + index">
                <button @click="selectPlayerItem(player_item)" class="flex relative">
                    @component('item::elements.check-item', ['alpine__is_show' => 'selected_player_items.includes(player_item)'])@endcomponent

                    {{-- Invent item --}}
                    <div class="w-full h-24 relative flex items-center justify-center overflow-hidden">
                        <div class="z-30 absolute top-1 right-2 flex items-center space-x-1 text-[10px] text-green-300">
                            <span><span x-text="player_item.price"></span> <i class="fas fa-coin"></i></span>
                        </div>
                        
                        @component('item::components.item-card', ['alpine__item' => 'player_item'])@endcomponent
                    </div>
                </button>
            </template>

            <x-buttons.actionable x-show="has_more_items" class="w-full h-24"
                @click="loadPlayerItems()"
                color="orange"
                size="normal"
                is-acting="is_player_items_loading"
                action="Еще"
            />
        </div>

        <div x-show="player_items.length == 0 && !is_player_items_loading" class="h-full w-full rounded-md relative flex items-center justify-center">
            <img class="absolute z-10 w-4/5 opacity-5" src="{{asset('img/jackpot/ak47.png')}}" alt="ak47">

            <x-banners.default class="rounded-md" title="Предметы не найдены" color="indigo" />
        </div>
    </div>

    <div class="flex mt-2 items-center relative pr-1">
        {{-- Enter shop button --}}
        <template x-if="invent_target_name !== 'shop'">
            <x-buttons.default @click="selectInventTarget('shop')" color="indigo"><span>Магазин скинов</span></x-buttons.default>
        </template>

        {{-- Desktop close shop button --}}
        <template x-if="window.screen.width >= 1024 && invent_target_name === 'shop'">
            <x-buttons.default @click="selectPrevInventTarget()" color="red"><span><i class="fas fa-times"></i> Закрыть</span></x-buttons.default>
        </template>

        {{-- Bet game modes button --}}
        <template x-if="is_show_make_bet">
            <x-buttons.actionable @click="makeBet()"
                color="orange"
                class="ml-2"
                disabled="selected_player_items.length === 0"
                is-acting="is_making_bet"
                acting="Ожидание..."
                action="Поставить"
            />
        </template>
    </div>

    {{-- Mobile shop --}}
    <template x-if="window.screen.width < 1024 && invent_target_name == 'shop'">
        <div x-data="{ is_open: false }" x-init="$watch('is_open', is_open => !is_open ? selectPrevInventTarget() : '')" x-effect="invent_target_name == 'shop' ? is_open = true : ''">
            <x-modal is-open="is_open">
                @include('shop::components.shop')
            </x-modal>
        </div>
    </template>

    {{-- Desktop shop --}}
    <template x-if="window.screen.width >= 1024 && invent_target_name == 'shop'">
        <div class="absolute top-0 left-full flex h-full z-40 shadow-lg" x-transition>
            @include('shop::components.shop')
        </div>
    </template>
</div>

