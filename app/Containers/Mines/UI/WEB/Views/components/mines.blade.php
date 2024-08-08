<div x-data="minesData({{$mines_game}})" class="grid grid-cols-12 gap-2">
    {{-- Bet panel --}}
    <div class="col-span-12 lg:col-span-5 w-full p-5 rounded-md bg-gray-900 flex flex-col space-y-5">
        <div class="flex flex-col space-y-2">
            <label class="text-gray-500 text-xs">Количество мин:</label>

            <div class="flex items-center overflow-x-auto flex-nowrap gap-2">
                <template x-for="count in buttons" :key="`buttons${count}`">
                    <button @click="count_mines = count" :disabled="isBetPanelDisabled" type="button" class="w-full inline-flex justify-center items-center text-white border px-2 py-2 rounded-md bg-opacity-50"
                        :class="count == count_mines ? 'border-red-300 bg-red-300' : 'border-gray-500 bg-gray-900'"
                    >
                        <span x-text="count"></span>
                    </button>
                </template>
            </div>
        </div>

        <div class="flex flex-col mines-input">
            <input :disabled="isBetPanelDisabled" autocomplete="off" type="range" step="1" min="2" max="24" x-model="count_mines">

            <div class="flex justify-between items-center text-gray-500 text-xs">
                <span>2</span>
                <span>24</span>
            </div>
        </div>

        <template x-if="$store.player.player == null">
            <x-banners.auth class="w-full rounded-md" />
        </template>

        <template x-if="$store.player.player != null">
            <div class="flex justify-center">
                <x-buttons.actionable @click="startGame()"
                    x-show="isShowStartGameButton" 
                    class="w-full" 
                    color="orange" 
                    action="Играть"
                    acting="Загрузка..." 
                    is-acting="is_starting_game" 
                />
                <x-buttons.actionable @click="takePrize()"
                    x-show="isShowTakePrizeButton" 
                    class="w-full" 
                    color="green" 
                    action="Забрать приз" 
                    is-acting="is_taking_prize" 
                />
                <x-banners.default x-show="isShowWaitFirstStepBanner" class="w-full rounded-md" title="Ожидание первого хода" color="green" />
                <x-banners.default x-show="isShowWaitFailBanner" class="w-full rounded-md" title="Проигрыш" color="red" />
            </div>
        </template>

        <div class="flex flex-col space-y-2">
            <label class="text-gray-500 text-xs">Коэффициенты:</label>

            <div class="flex items-center overflow-x-scroll overflow-y-hidden pb-1 flex-nowrap gap-2">
                <template x-for="(coefficient, index) in coefficients" :key="`coefficients${coefficient}`">
                    <span class="flex-shrink-0 inline-flex flex-col justify-center items-center bg-gray-1000 px-3 py-1.5 rounded-md" :class="{'border border-green-300': step == index + 1}">
                        <span class="text-white text-sm">x<span x-text="coefficient"></span></span>
                        <span class="text-gray-500 text-xs" x-text="index + 1"></span>
                    </span>
                </template>
            </div>
        </div>

        <div class="flex items-center gap-2">            
            <div class="bg-gray-1000 w-full rounded-sm px-3 py-1.5 flex items-center justify-between">
                <div class="inline-flex text-sm space-x-1">
                    <span class="text-green-300"><x-icons.currency /></span>

                    <span class="text-gray-400">выигрыш</span>
                </div>

                <span class="text-white text-sm"><span x-text="currentPrizeAmount"></span></span>
            </div>
            
            <div class="bg-gray-1000 w-full rounded-sm px-3 py-1.5 flex items-center justify-between">
                <div class="inline-flex text-sm space-x-1">
                    <span><i class="text-red-300 fas fa-bomb"></i></span>

                    <span class="text-gray-400">мин</span>
                </div>

                <span class="text-white text-sm"><span x-text="count_mines"></span></span>
            </div>
        </div>
    </div>

    {{-- Cells area --}}
    <div class="col-span-12 lg:col-span-7 w-full h-full bg-gray-900 p-5 flex justify-center items-center">
        <div class="w-full h-full flex justify-center items-center">
            <div class="grid grid-cols-5 gap-2">
                <template x-for="i in size" :key="i">
                    <div class="col-span-5 flex flex-nowrap gap-2">
                        <template x-for="k in size" :key="k">
                            <div class="relative flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden" x-data="{ cell_index: k + size * (i - 1) }">
                                <button :disabled="isOpenCellDisabled" :id="`cell${cell_index}`" class="relative z-0 w-full h-full bg-gray-800 animate__animated animate__faster" type="button" @click="openCell(cell_index)"></button>
    
                                <div :id="`cellResult${cell_index}`" class="absolute top-0 left-0 z-10 hidden flex items-center justify-center w-full h-full bg-gray-800 animate__animated animate__faster text-2xl">
                                    <span x-show="mines_game?.cell_results[cell_index]"><i class="text-green-300 fas fa-check"></i></span>
                                    <span x-show="!mines_game?.cell_results[cell_index]"><i class="text-red-300 fas fa-bomb"></i></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>