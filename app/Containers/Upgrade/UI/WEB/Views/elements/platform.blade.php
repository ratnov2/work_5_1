<div class="flex gap-2 w-full justify-center items-center relative">
    {{-- Left platfrom --}}
    <div class="relative z-10 flex w-full h-124 md:h-[340px] bg-gray-900 justify-center items-center rounded-l-xl pr-0 md:pr-20">
        {{-- Player Item --}}
        <template x-if="selected_player_item != null">
            @component('upgrade::elements.platform-item', ['alpine__item' => 'selected_player_item', 'alpine__removeItem' => 'removeSelectedPlayerItem'])@endcomponent
        </template>
        {{-- Empty Item --}}
        <template x-if="selected_player_item == null">
            <div class="flex relative justify-center items-end w-full md:w-2/3 h-full">
                <img class="absolute z-0" src="{{ asset('img/upgrade/platform/no_active_platform.png') }}" alt="no_active_platform">
            </div>
        </template>
        {{-- Chance --}}
        <span class="absolute top-5 right-auto md:right-5 left-5 md:left-auto text-2xl text-green-300"><span x-text="chance ?? 0"></span>%</span>
    </div>

    {{-- Middle panel --}}
    <div class="absolute z-20 top-0 md:top-auto flex flex-col space-y-3">
        {{-- Circle --}}
        <div class="relative flex items-center justify-center rounded-full border-8 border-gray-1000 h-40 w-40 bg-gray-900">
            {{-- Animating result --}}
            <div x-show="is_animating_result" x-transition class="absolute z-0 rounded-full w-full h-full flex items-center justify-center bg-gray-900">
                <span class="absolute w-full h-full z-20" x-html="chart_html"></span>
                <div class="absolute flex justify-center w-4/5 h-4/5 rounded-full border-2 border-gray-500" :style="`transition: all ${animation_ms}ms cubic-bezier(0, 0, 0, 1); transform: rotateZ(${animation_rotation_deg}deg)`">
                    <span class="absolute -top-5 text-3xl text-gray-200"><i class="fas fa-caret-up"></i></span>
                </div>
                <div class="flex justify-center items-center w-full text-3xl text-white">
                    <i style="animation-delay: 0ms" class="upgrade_arrow fad fa-angle-right"></i>
                    <i style="animation-delay: 100ms" class="upgrade_arrow fad fa-angle-right"></i>
                    <i style="animation-delay: 200ms" class="upgrade_arrow fad fa-angle-right"></i>
                    <i style="animation-delay: 300ms" class="upgrade_arrow fad fa-angle-right"></i>
                    <i style="animation-delay: 400ms" class="upgrade_arrow fad fa-angle-right"></i>
                </div>
            </div>
            {{-- Showing result --}}
            <div x-show="is_showing_result" class="absolute z-10 rounded-full w-full h-full flex items-center justify-center border-8 bg-opacity-30 animate__animated"
                :class="{
                    'animate__rotateIn': !is_success,
                    'bg-red-500': !is_success,
                    'border-red-400': !is_success,
                    'animate__bounceIn': is_success,
                    'bg-green-300': is_success,
                    'border-green-400': is_success
                }">
                <span x-show="!is_success" class="text-red-400 text-3xl"><i class="fas fa-times"></i></span>
                <span x-show="is_success" class="text-green-300 text-3xl"><i class="fas fa-check"></i></span>
            </div>
        </div>
        {{-- Button --}}
        <div class="border-8 border-gray-1000 bg-gray-900 rounded-lg">
            <x-buttons.actionable @click="makeUpgrade()"
                color="green"
                class="uppercase"
                is-disabled="!isCorrectChance"
                is-acting="is_make_upgrade"
                action='<i class="fas fa-chevron-double-up"></i> Апгрейд'
            />
        </div>
    </div>

    {{-- Right platfrom --}}
    <div class="relative z-10 flex w-full h-124 md:h-[340px] bg-gray-900 justify-center items-center rounded-r-xl pl-0 md:pl-20">
        {{-- X kof --}}
        <span class="absolute top-5 left-auto md:left-5 right-5 md:right-auto text-2xl text-orange-300"><span x-text="xKof ?? 0"></span>x</span>
        {{-- Empty Item --}}
        <template x-if="wanted_item == null">
            <div class="flex relative justify-center items-end w-full md:w-2/3 h-full">
                <div class="absolute z-10 h-64 md:h-full">
                    <div class="h-full flex items-end justify-center">
                        <img class="z-30 absolute bottom-0 flash_light" src="{{ asset('/img/upgrade/light/active_light.png') }}" alt="light">
                        <img class="w-20 absolute z-20 bottom-[100px] ml-2.5 move_item" src="{{ asset('/img/upgrade/question.png') }}" alt="item">
                        <img class="z-10 flash_light" src="{{ asset('/img/upgrade/platform/active_platform.png') }}" alt="platform">
                    </div>
                </div>
                <img class="absolute z-0" src="{{ asset('img/upgrade/platform/no_active_platform.png') }}" alt="no_active_platform">
            </div>
        </template>
        {{-- Wanted Item --}}
        <template x-if="wanted_item != null">
            @component('upgrade::elements.platform-item', ['alpine__item' => 'wanted_item', 'alpine__removeItem' => 'removeWantedItem'])@endcomponent
        </template>
    </div>
</div>

