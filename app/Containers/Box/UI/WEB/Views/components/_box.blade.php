<div x-data="{{$alpine_data}}({{$alpine_data_params}})" :class="!is_opening_box ? 'opacity-100' : 'opacity-50'" class="relative transition duration-150 h-48 mx-auto flex flex-col items-center justify-center w-full rounded-md shadow-md bg-gray-900 overflow-hidden">
    <div class="flex items-center justify-between px-3 bg-gray-800 bg-opacity-40 w-full h-8 flex-shrink-0">
        <div class="space-x-2 flex items-center">
            <span class="text-sm text-orange-300">{!! $icon !!}</span>
            <p class="text-sm text-gray-200">{!! $title !!}</p>
        </div>

        {!! $header ?? '' !!}
    </div>

    <div class="w-full h-full relative">
        {{-- No auth card --}}
        <div class="w-full h-full z-20 absolute left-0 bottom-0" x-show="$store.player.player == null">
            <x-banners.auth />
        </div>

        {{-- Drop line --}}
        <div x-show="dropLineIsShow" class="absolute z-40 left-0 top-0 w-full h-full bg-gray-900 flex justify-center">
            <span class="z-10 absolute -top-5 text-5xl text-yellow-500"><i class="fas fa-angle-down"></i></span>

            <div :style="`transform: translateX(${dropLineTranslateX}px); transition: all ${DROP_LINE_TRANSITION_MS}ms 0s ease;`" class="flex flex-nowrap space-x-0.5">
                <template x-for="(item, index) in dropLineItems" :key="index + '-' + item.market_hash_name">
                    <div class="h-full w-44">@component('item::components.item-card', ['alpine__item' => 'item'])@endcomponent</div>
                </template>
            </div>
        </div>

        {{-- Box area --}}
        <div class="w-full h-full grid grid-cols-2 gap-2 items-center">
            <template x-if="winItem == null">
                <div class="w-full h-full grayscale-[30%]">
                    {!! $image !!}
                </div>
            </template>

            <template x-if="winItem != null"> @component('item::components.item-card', ['alpine__item' => 'winItem'])@endcomponent </template>

            <div class="flex flex-col justify-center space-y-1.5 pr-4">
                {{-- Select mode --}}
                <div class="flex items-center justify-center space-x-1 text-[12px]">
                    <div class="flex items-center space-x-0.5">
                        <span class="text-gray-500 relative group inline-flex justify-center">
                            <i class="fad fa-info-circle"></i>
                            <div class="w-auto group-hover:visible normal-case invisible absolute top-full z-30 space-y-1 bg-gray-900 text-gray-50 rounded px-4 py-2 shadow-md text-xs">
                                <p>- <span class="text-yellow-500">Вкл</span>: результат показывается сразу <br>- <span class="text-gray-500">Выкл</span>: результат после прокрутки</p>
                            </div>
                        </span>

                        <span class="text-gray-400">Турбо режим:</span>
                    </div>

                    <button class="underline decoration-dashed" @click="boxSwitchMode()" :class="boxMode == 'fast' ? 'text-orange-300' : 'text-gray-500'">
                        <span x-show="boxMode == 'fast'">Вкл</span>
                        <span x-show="boxMode == 'normal'">Выкл</span>
                    </button>
                </div>

                {{-- Extra --}}
                {!! $open_extra ?? '' !!}

                {{-- Open button --}}
                <div x-data="conditionAnyCheckerData(box.condition)" class="condition-any-checker">
                    <x-buttons.actionable @click="open()" 
                        color="orange" 
                        action="Открыть" 
                        is-acting="is_opening_box"
                    />
                </div>

                {{-- Condition button --}}
                @component('condition::elements.condition-button', ['alpine__condition' => 'box.condition'])@endcomponent
            </div>
        </div>
    </div>
</div>
