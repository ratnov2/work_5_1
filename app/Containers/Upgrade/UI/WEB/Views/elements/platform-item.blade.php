<div class="w-full md:w-2/3 h-full flex justify-center items-end relative">
    <div class="absolute z-10 h-64 md:h-full">
        <div class="h-full flex items-end justify-center">
            <img class="z-30 absolute bottom-0 flash_light" :src="'/img/upgrade/light/' + {{$alpine__item}}?.rarity + '_light.png'" alt="light">
            <img class="w-2/3 absolute z-20 bottom-[100px] move_item" :src="'https://cdn.csgo.com/item/' + {{$alpine__item}}?.market_hash_name + '/300.png'" alt="item">
            <img class="z-10 flash_light" :src="'/img/upgrade/platform/' + {{$alpine__item}}?.rarity + '_platform.png'" alt="platform">
        </div>
    </div>

    <img class="absolute z-0" src="{{ asset('img/upgrade/platform/no_active_platform.png') }}" alt="no_active_platform">

    <div class="absolute bottom-0 md:bottom-2.5 flex items-center justify-center gap-2 z-20">
        {{-- Item name --}}
        <span class="hidden md:inline-block text-sm text-white max-w-[180px] line-clamp-1 whitespace-nowrap text-ellipsis overflow-hidden" x-text="{{$alpine__item}}?.market_hash_name"></span>
        {{-- Remove item callback --}}
        <button class="text-lg text-red-300" @click="{{$alpine__removeItem}}()"><i class="fas fa-times-square"></i></button>
        {{-- Item price --}}
        <span class="text-sm text-green-300 flex flex-nowrap items-center gap-1">
            <span x-text="{{$alpine__item}}?.price"></span>
            <x-icons.currency />
        </span>
    </div>
</div>
