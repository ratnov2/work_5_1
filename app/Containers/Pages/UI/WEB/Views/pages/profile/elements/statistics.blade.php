<div class="flex flex-col w-full space-y-2">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
        {{-- Favorite box --}}
        @component('pages::pages.profile.elements.statistics-top-card', ['is_show' => $statistics['player_favorite_box'] != null, 'title' => 'Любимый кейс', 'sub_title' => $statistics['player_favorite_box']?->name])
            <x-slot name="left">
                <a href="#/game-modes"><x-buttons.default color="orange" size="normal">Открыть</x-buttons.default></a>
            </x-slot>

            <x-slot name="right">
                <img class="grayscale-[40%] absolute z-10 h-full right-3 bottom-3 scale-[2]" src="{{ $statistics['player_favorite_box']?->image }}" alt="player_favorite_box">
            </x-slot>
        @endcomponent

        {{-- Best drop --}}
        @component('pages::pages.profile.elements.statistics-top-card', ['is_show' => $statistics['player_best_item'] != null, 'sub_title' => ''])
            <x-slot name="title">
                <span class="text-green-300">Лучший дроп</span>
            </x-slot>

            <x-slot name="left">
                <span x-data="{ player_best_item: {{ $statistics['player_best_item'] }} }" class="px-7 py-3 text-sm text-green-300 border border-green-300 rounded"><span x-text="player_best_item?.price"></span> <x-icons.currency /></span>
            </x-slot>

            <x-slot name="right">
                <div class="w-full h-full" x-data="{ player_best_item: {{ $statistics['player_best_item'] }} }">
                    @component('item::components.item-card', ['alpine__item' => 'player_best_item'])@endcomponent
                </div>
            </x-slot>
        @endcomponent
    </div>

    {{-- Statistics --}}
    <div class="flex flex-nowrap flex-grow space-x-2">
        @php
            $cards = [
                ['icon' => '<i class="fas fa-box"></i>', 'value' => $statistics['count_boxes'], 'desc' => 'Открыто кейсов'],
                ['icon' => '<i class="fad fa-circle-notch"></i>', 'value' => $statistics['count_jackpot_bets'], 'desc' => 'Ставок Джекпот'],
                ['icon' => '<i class="fad fa-chevron-double-up"></i>', 'value' => $statistics['count_upgrades'], 'desc' => 'Апгрейдов'],
            ];
        @endphp

        @foreach($cards as $card)
            <div class="w-full flex justify-center items-center rounded-md bg-gray-900 p-4">
                <span class="inline-flex items-center space-x-2">
                    <span class="text-orange-300 text-2xl font-bold">{!! $card['icon'] !!}</span>

                    <span class="inline-flex flex-col -space-y-2">
                        <span class="text-orange-300 text-xl">{{ $card['value'] }}</span>
                        <span class="hidden sm:inline-flex text-gray-500 text-sm">{{ $card['desc'] }}</span>
                    </span>
                </span>
            </div>
        @endforeach
    </div>
</div>
