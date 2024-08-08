<div class="rounded-md relative overflow-hidden relative">
    <span class="absolute z-10 text-sm text-gray-200 top-1 left-3">{{$top_contest_player['place']}}</span>
    <div class="z-0 bg-gray-900 absolute w-full h-full"></div>
    <div class="z-10 p-3 relative flex flex-nowrap items-center space-x-2 ml-5">
        <div class="bg-contain bg-no-repeat w-8 h-8 rounded-lg flex-shrink-0 bg-gray-800" style="background-image: url({{$top_contest_player['player'] ? $top_contest_player['player']->image : ''}}"></div>
        <div class="flex flex-col -space-y-1 text-sm">
            <span class="text-white w-28 line-clamp-1 whitespace-nowrap text-ellipsis overflow-hidden">{{$top_contest_player['player'] ? $top_contest_player['player']->name : 'Место свободно'}}</span>
            <span class="text-green-300"><x-icons.currency /> {{$top_contest_player['sum'] ?? '???'}}</span>
            <span class="text-xs text-gray-400">Поставлено</span>
        </div>
    </div>
</div>
