<div x-data="itemCardData({{$alpine__item}})" class="overflow-hidden w-full h-full p-2 flex flex-col flex-shrink-0 items-center justify-center relative rounded-md">
    <span class="absolute inline-flex items-center justify-center left-2 space-x-1 opacity-50" :class="{
        'top-1': {{$alpine__item}}.quality,
        'top-2': !{{$alpine__item}}.quality,
    }">
        <span class="w-1.5 h-1.5 rounded-full" :class="{
            'bg-gray-300': {{$alpine__item}}.rarity == 'common',
            'bg-cyan-400': {{$alpine__item}}.rarity == 'uncommon',
            'bg-indigo-400': {{$alpine__item}}.rarity == 'milspec',
            'bg-purple-400': {{$alpine__item}}.rarity == 'restricted',
            'bg-pink-400': {{$alpine__item}}.rarity == 'classified',
            'bg-red-400': {{$alpine__item}}.rarity == 'covert',
            'bg-orange-300': {{$alpine__item}}.rarity == 'rare',
        }"></span>

        <span class="text-[10px] font-bold" x-text="{{$alpine__item}}.quality" :class="{
            'text-gray-300': {{$alpine__item}}.rarity == 'common',
            'text-cyan-400': {{$alpine__item}}.rarity == 'uncommon',
            'text-indigo-400': {{$alpine__item}}.rarity == 'milspec',
            'text-purple-400': {{$alpine__item}}.rarity == 'restricted',
            'text-pink-400': {{$alpine__item}}.rarity == 'classified',
            'text-red-400': {{$alpine__item}}.rarity == 'covert',
            'text-orange-300': {{$alpine__item}}.rarity == 'rare',
        }"></span>
    </span>

    <div class="absolute w-full h-full bg-gradient-to-b opacity-20"
        :class="{
            'from-gray-400': {{$alpine__item}}.rarity == 'common',
            'from-cyan-600': {{$alpine__item}}.rarity == 'uncommon',
            'from-indigo-600': {{$alpine__item}}.rarity == 'milspec',
            'from-purple-600': {{$alpine__item}}.rarity == 'restricted',
            'from-pink-600': {{$alpine__item}}.rarity == 'classified',
            'from-red-600': {{$alpine__item}}.rarity == 'covert',
            'from-yellow-500': {{$alpine__item}}.rarity == 'rare',
        }"
    >
    </div>

    <img class="absolute z-20 w-2/3" :src="'https://cdn.csgo.com/item/' + {{$alpine__item}}.market_hash_name + '/150.png'" alt="item">

    <div class="flex flex-col w-full relative z-20 mt-auto -space-y-1 text-left -mb-0.5">
        <span class="text-xss text-white opacity-60 line-clamp-1 whitespace-nowrap text-ellipsis overflow-hidden" x-text="topName"></span>
        <span class="text-xs text-gray-200 line-clamp-1 whitespace-nowrap text-ellipsis overflow-hidden" x-text="bottomName"></span>
    </div>
</div>
