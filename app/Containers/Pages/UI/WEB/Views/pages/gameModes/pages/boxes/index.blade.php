<div class="w-full h-full flex flex-col space-y-5 overflow-y-auto pr-2">
    @if(count($boxes_money_json_category_name) > 0)
        @foreach ($boxes_money_json_category_name as $boxes_money_json_category)
            <div class="flex flex-col w-full space-y-2">
                <div class="flex flex-col items-center justify-center relative w-full">
                    <p class="border-b-2 border-orange-300 z-10">
                        <span class="text-white text-2xl">{{ $boxes_money_json_category['category_name'] }}</span>
                    </p>
                    <div class="flex h-0.5 bg-gray-600 w-full opacity-10 absolute z-0 bottom-0"></div>
                </div>

                @if(count($boxes_money_json_category['boxes_money_json']) > 0)
                    <div class="grid grid-cols-1 xl:grid-cols-2 gap-2">
                        @foreach ($boxes_money_json_category['boxes_money_json'] as $box_json)
                            @component('boxmoney::components.box-money', ['box_json' => $box_json])@endcomponent
                        @endforeach
                    </div>
                @else
                    <x-banners.default class="rounded-md" title="{{'Кейсов в категории ' . $boxes_money_json_category['category_name'] . ' не найдено'}}" desc="Возвращайтесь позже!" color="indigo" />
                @endif
            </div>
        @endforeach
    @else
        <x-banners.default class="rounded-md" title="Кейсов не найдено" desc="Возвращайтесь позже!" color="indigo" />
    @endif
</div>
