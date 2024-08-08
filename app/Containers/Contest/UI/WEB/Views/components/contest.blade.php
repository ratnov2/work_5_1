<div x-data="contestData({{$contest_json}})" :class="!is_entering ? 'opacity-100' : 'opacity-50'" class="transition duration-150 h-48 bg-gray-800 bg-opacity-70 mx-auto w-full flex flex-col rounded-md shadow-md border border-gray-800 overflow-hidden">
    <div class="flex w-full h-full space-x-2">
        {{-- Item --}}
        <div class="flex flex-col items-center justify-center">
            @component('contest::elements.item', ['alpine__item' => 'contest.item'])@endcomponent
        </div>

        <div class="flex flex-grow flex-col space-y-3 items-start justify-center">
            {{-- Title --}}
            <template x-if="contest.type == 'default'">
                <div class="text-xs sm:text-sm flex space-x-2 items-center mt-2">
                    <i class="text-green-300 fad fa-gift"></i>
                    <p class="text-white">Бесплатный розыгрыш</p>
                </div>
            </template>
            <template x-if="contest.type == 'sponsor'">
                <div class="text-xs sm:text-sm flex space-x-2 items-center mt-2">
                    <i x-show="contest.type == 'sponsor'" class="text-orange-300 fas fa-crown"></i>
                    <p x-show="contest.type == 'sponsor'" class="text-white">Королевский розыгрыш</p>
                </div>
            </template>

            {{-- Type --}}
            <div class="w-full">
                <div class="bg-gray-800 h-2 rounded-lg stripes animated reverse slower mr-2">
                    <span :style="{width: progress + '%'}" class="progress-bar-inner block h-2 rounded-lg relative"
                        :class="{
                            'bg-indigo-400': contest.type == 'default',
                            'bg-orange-300': contest.type == 'sponsor',
                        }">
                    </span>
                </div>
            </div>

            {{-- Auth --}}
            <template x-if="$store.player.player != null">
                <div class="w-full h-full">
                    <template x-if="isContester">
                        <x-banners.default title="Вы участник" color="green" />
                    </template>

                    <template x-if="!isContester">
                        <div class="pr-2 py-2 flex flex-col justify-between">
                            <span x-data="conditionAnyCheckerData(contest.condition)" class="condition-any-checker">
                                <x-buttons.actionable @click="enter(contest.id)" 
                                    color="orange" 
                                    is-acting="is_entering" 
                                    action="Участвовать" 
                                />
                            </span>

                            @component('condition::elements.condition-button', ['alpine__condition' => 'contest.condition'])@endcomponent
                        </div>
                    </template>
                </div>
            </template>

            {{-- No Auth --}}
            <template x-if="$store.player.player == null">
                <x-banners.auth />
            </template>
        </div>
    </div>

    {{-- Timer and count players --}}
    <div class="bg-gray-800 bg-opacity-40 col-span-12 py-2 px-4 w-full justify-between items-center flex border-t border-gray-600">
        <div class="items-center flex space-x-2" :class="{
                'text-gray-200': contest.type == 'default',
                'text-orange-300': contest.type == 'sponsor',
            }"
        >
            <span class="text-sm"><i class="fas fa-clock"></i></span>
            <div x-data="timerData(contest_expiry)" class="flex items-center text-sm space-x-1">
                <span x-text="time.days"></span>
                <span>:</span>
                <span x-text="time.hours"></span>
                <span>:</span>
                <span x-text="time.minutes"></span>
                <span>:</span>
                <span x-text="time.seconds"></span>
            </div>
        </div>
        <div class="space-x-2 flex items-center text-indigo-400">
            <span><i class="fas fa-users"></i></span>
            <span x-text="contest.count_players"></span>
        </div>
    </div>
</div>
