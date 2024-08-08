<div class="w-full h-[200px] flex flex-col rounded-md bg-gradient-to-br from-gray-800 via-gray-1000 to-gray-900 overflow-hidden">
    <span class="text-xl text-orange-300 pl-3 pt-3 pb-2 uppercase font-bold">{{ $title }}</span>
    @if($is_show)
        <span class="text-white text-xl -mt-1 pl-3">{{ $sub_title }}</span>

        <div class="h-full relative grid grid-cols-2">
            <div class="flex items-center justify-center">
                {{ $left }}
            </div>

            {{ $right }}
        </div>
    @else
        <x-banners.default title="Не найдено" color="indigo" />
    @endif
</div>
