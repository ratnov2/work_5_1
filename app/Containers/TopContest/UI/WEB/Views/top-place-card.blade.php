<div class="relative rounded-md w-full overflow-hidden">
    <div class="absolute w-full h-full z-0 bg-gray-900"></div>
    <div class="z-10 relative grid grid-cols-2">
        <div class="w-full h-full relative">
            <div class="z-20 absolute top-1 right-2 flex items-center space-x-1 text-[10px] text-green-300">
                <span>{{$top_contest_player['item']->price}} <i class="fas fa-coin"></i></span>
            </div>
            @component('item::components.item-card', ['alpine__item' => $top_contest_player['item']])@endcomponent
        </div>
        <div class="flex flex-col space-y-3 items-center py-3 pr-3">
            <div class="w-full flex justify-center rounded-md relative">
                <div @class(['relative', 'flex', 'items-center', 'justify-center', 'bg-opacity-0', 'rounded-full', 'w-20', 'h-20',
                    'text-yellow-300' => $top_contest_player['place'] == 1,
                    'text-indigo-300' => $top_contest_player['place'] == 2,
                    'text-orange-300' => $top_contest_player['place'] == 3
                ])>
                    <span class="text-6xl"><i class="fad fa-trophy-alt"></i></span>
                </div>
                <div class="absolute z-10 -bottom-2 right-2">
                    <div class="bg-contain bg-no-repeat rounded-md z-0 w-10 h-10" style="background-image: url({{$top_contest_player['player'] ? $top_contest_player['player']->image : asset('img/logo_tg.jpg')}})"></div>
                </div>
            </div>
            <div class="w-full flex flex-col items-end -space-y-1 text-sm">
                <span class="text-white w-28 line-clamp-1 whitespace-nowrap text-ellipsis overflow-hidden text-right">{{$top_contest_player['player'] ? $top_contest_player['player']->name : 'Место свободно'}}</span>
                <span class="text-green-300"><x-icons.currency /> {{$top_contest_player['sum'] ?? '???'}}</span>
                <span class="text-xs text-gray-400">Поставлено</span>
            </div>
        </div>
    </div>
</div>
