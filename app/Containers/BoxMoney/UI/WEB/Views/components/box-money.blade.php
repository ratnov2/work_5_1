@component('box::components._box', [
    'alpine_data' => 'boxMoneyData',
    'alpine_data_params' => $box_json,
])
    <x-slot name="icon">
        <i class="fas fa-box"></i>
    </x-slot>

    <x-slot name="title">
        <span x-text="box.name"></span>
    </x-slot>

    <x-slot name="image">
        <div class="h-full w-full" :style="`transform: scale(1.1); background: center / contain no-repeat url(${box.image})`"></div>
    </x-slot>

    <x-slot name="header">
        <span class="text-xs text-white ml-auto">
            Предмет от <span class="text-green-300" x-text="box.min_item_price"></span>
            до <span class="text-green-300" x-text="box.max_item_price"></span>
            <x-icons.currency />
        </span>
    </x-slot>

    <x-slot name="open_extra">
        <div class="w-full flex justify-center text-sm">
            <span class="text-white mr-1">Стоимость:</span>
            <span class="text-green-300">
                <span x-text="box.price"></span>
                <x-icons.currency />
            </span>
        </div>
    </x-slot>
@endcomponent
