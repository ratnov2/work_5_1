<div x-data="paymentWindowData()" class="flex space-y-2 md:space-y-0 space-x-0 md:space-x-2 flex-col md:flex-row overflow-y-auto">
    {{-- Make payment --}}
    <div class="w-full sm:w-[600px] md:w-[500px] lg:w-[600px] xl:w-[800px] h-full flex flex-col bg-gray-800 p-4 relative rounded-md">
        {{-- Paymnet info --}}
        <template x-if="info_html != ''">
            <div class="w-full h-full flex flex-col space-y-4">
                <div class="flex space-x-2">
                    <button @click="info_html = ''" class="text-sm text-gray-500">
                        <i class="fas fa-angle-left"></i> Назад
                    </button>
                    <h2 class="text-white text-xl uppercase">Пополнение баланса</h2>
                </div>
                <div class="h-full" x-html="info_html"></div>
            </div>
        </template>

        <template x-if="info_html == ''">
            <div class="w-full h-full flex flex-col space-y-4">
                {{-- Categories --}}
                <div class="flex flex-col space-y-4">
                    <h2 class="text-white text-xl uppercase">Пополнение баланса</h2>

                    <div class="flex flex-wrap rounded-md overflow-hidden bg-gray-900">
                        <template x-for="category in categories" :key="category.slug">
                            <button @click="selectCategory(category)"
                                class="text-xs sm:text-sm text-gray-500 py-2 sm:py-3 px-3 sm:px-6 flex items-center justify-center"
                                :class="{
                                    'text-gray-500': selected_category != category,
                                    'text-green-300': selected_category == category,
                                }"
                                x-text="category.name">
                            </button>
                        </template>
                    </div>
                </div>

                {{-- Directions --}}
                <div x-show="selected_category && selected_category.slug">
                    <div class="w-full h-40 sm:h-80 flex items-start overflow-y-auto overflow-x-hidden pr-4">
                        {{-- Directions found --}}
                        <template x-if="filteredDirections.length != 0">
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 w-full gap-1">
                                <template x-for="(direction, index) in filteredDirections" :key="'filteredDirections' + index">
                                    <button @click="selectDirection(direction)" class="p-2 w-full h-20 bg-gray-700 rounded-xl flex items-center justify-center relative z-20 overflow-hidden">
                                        <div x-show="selected_direction == direction" class="rounded-md absolute z-30 h-full w-full bg-green-400 bg-opacity-30">
                                            <span class="-bottom-6 -right-2 absolute text-green-300 text-8xl opacity-30"><i class="fas fa-check"></i></span>
                                        </div>
                                        <div class="relative w-full h-full bg-contain bg-no-repeat bg-center" :style="'background-image: url(' + direction.image + ')'"></div>
                                        <span class="absolute left-2 top-2 bg-gray-700 text-xs rounded-md px-1 text-gray-100" x-text="direction.name"></span>
                                    </button>
                                </template>
                            </div>
                        </template>
                        {{-- Directions not found --}}
                        <template x-if="filteredDirections.length == 0">
                            <x-banners.default class="rounded-md py-4" title="Доступных направлений платежей не найдено" color="indigo" />
                        </template>
                    </div>

                    {{-- Qiwi desc --}}
                    <div class="flex w-full text-gray-400 text-sm mt-2">
                        <p>Внимание! При пополнении через Qiwi средства поступят на счет в течение 1-5 минут.</p>
                    </div>

                    {{-- Input --}}
                    <div class="flex flex-wrap sm:flex-nowrap w-full justify-center items-center space-y-2 sm:space-y-0 space-x-0 sm:space-x-2 py-1 mt-2">
                        {{-- Payment sun input --}}
                        <template x-if="selected_direction">
                            <div class="w-full sm:w-auto" :class="selected_direction.is_need_sum ? 'flex' : 'hidden'">
                                <div class="text-md px-4 py-2.5 rounded-tl-md rounded-bl-md text-green-300 border-t-2 border-l-2 border-b-2 border-green-400 bg-gray-700">
                                    <x-icons.currency />
                                </div>
                                <input :disabled="!selected_direction.is_need_sum" type="number" step="0.01"
                                    class="w-full border-t-2 border-r-2 border-b-2 border-green-400 focus:outline-none rounded-tr-md rounded-br-md focus:border-green-400 text-green-300 p-2 bg-gray-800 text-md"
                                    x-model="sum"
                                >
                            </div>
                        </template>

                        {{-- Make payment button --}}
                        <span>
                            <x-buttons.actionable @click="makePayment()" 
                                is-disabled="!selected_direction" 
                                color="green" 
                                action="Пополнить" 
                                is-acting="is_making_payment" 
                            />
                        </span>
                    </div>
                </div>
            </div>
        </template>
    </div>

    {{-- Bonus system --}}
    <div class="h-full flex flex-col bg-gray-800 p-4 relative rounded-md space-y-4">
        <h2 class="text-white text-xl uppercase">Бонус</h2>

        <div class="bg-gray-900 h-7 rounded-md w-full relative flex items-center">
            <span class="absolute right-2 uppercase text-[10px] text-white">Общий бонус <span x-text="paymentFinalPrecent"></span>%</span>
            <div :style="{ width: paymentFinalPrecent + '%' }" class="h-full rounded-md relative bg-green-400"></div>
        </div>

        <div class="flex flex-col space-y-1">
            <div class="flex w-full text-xs">
                <div class="text-white px-2 py-1 rounded-tl-md rounded-bl-md bg-gray-700 bg-opacity-50">
                    <span x-text="$store.player.player.referrer_bonus_precent ?? 0"></span>%
                </div>

                <div class="text-gray-500 px-2 py-1 rounded-tr-md rounded-br-md bg-gray-900 flex-grow text-center" :class="{
                    'text-green-300': $store.player.player.referrer_bonus_precent,
                    'text-gray-500': !$store.player.player.referrer_bonus_precent,
                }">
                    Бонус от реферера
                </div>
            </div>

            <div class="flex w-full text-xs">
                <div class="text-white px-2 py-1 rounded-tl-md rounded-bl-md text-white bg-gray-700 bg-opacity-50">
                    <span x-text="promocode?.precent ?? 0"></span>%
                </div>

                <div class="text-gray-500 px-2 py-1 rounded-tr-md rounded-br-md bg-gray-900 flex-grow text-center" :class="{
                    'text-green-300': promocode != null,
                    'text-gray-500': promocode == null,
                }">
                    Промокод
                </div>
            </div>
        </div>

        <div class="rounded-md p-3 bg-gray-900 space-y-1">
            <span class="text-gray-50 uppercase text-md">Промокод</span>

            <div class="flex items-center p-2 text-gray-300 rounded-md bg-gray-700 bg-opacity-50 space-x-1">
                <input x-model="promocode_value" type="text" class="text-sm border-none outline-none flex-grow" style="background: none" placeholder="Введите код">

                <button class="bg-green-300 text-gray-900 inline-flex rounded-md w-6 h-6 justify-center items-center overflow-hidden" @click="checkPromocode()" :disabled="is_checking_promocode" :class="is_checking_promocode ? 'opacity-20 grayscale' : 'opacity-100 grayscale-0'">
                    <span x-show="is_checking_promocode" class="h-5 w-5 inline-flex"><x-icons.spinner /></span>
                    <span x-show="!is_checking_promocode"><i class="fas fa-check"></i></span>
                </button>
            </div>
        </div>
    </div>
</div>
