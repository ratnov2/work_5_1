<div class="w-36 h-24 md:w-40 md:h-28 relative flex items-center justify-center overflow-hidden rounded">
    <div class="relative z-10 h-full w-full">
        <div @class([
                'overflow-hidden', 'w-full', 'h-full', 'p-2', 'flex', 'flex-col', 'flex-shrink-0', 'items-center', 'justify-center', 'relative', 'border-l-2',
                'border-gray-300' => $item->rarity == 'common',
                'border-cyan-400' => $item->rarity == 'uncommon',
                'border-indigo-400' => $item->rarity == 'milspec',
                'border-purple-400' => $item->rarity == 'restricted',
                'border-pink-400' => $item->rarity == 'classified',
                'border-red-400' => $item->rarity == 'covert',
                'border-orange-300' => $item->rarity == 'rare',
        ])>
            <div @class([
                    'absolute', 'w-full', 'h-full', 'bg-gradient-to-r', 'opacity-20',
                    'from-gray-400' => $item->rarity == 'common',
                    'from-cyan-600' => $item->rarity == 'uncommon',
                    'from-indigo-600' => $item->rarity == 'milspec',
                    'from-purple-600' => $item->rarity == 'restricted',
                    'from-pink-600' => $item->rarity == 'classified',
                    'from-red-600' => $item->rarity == 'covert',
                    'from-yellow-500' => $item->rarity == 'rare',
                ])>
            </div>

            <img class="absolute z-10 w-2/3" src="https://cdn.csgo.com/item/{{$item->market_hash_name}}/300.png" alt="item">

            <div class="flex flex-col w-full relative z-20 mt-auto -space-y-1 text-left">
                @php
                    $name = explode(' | ', $item->market_hash_name);
                @endphp
                <span class="text-sm md:text-sm text-white line-clamp-1 whitespace-nowrap text-ellipsis overflow-hidden">{{$name[0]}}</span>
                <span class="text-xss md:text-xs text-gray-300 line-clamp-1 whitespace-nowrap text-ellipsis overflow-hidden">{{ isset($name[1]) ? $name[1] : ''}}</span>
            </div>
        </div>
    </div>
</div>
