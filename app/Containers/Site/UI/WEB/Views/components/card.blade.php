@props([
    'siteJson'
])

<div {{$attributes}} x-data="{
    site: {!!$siteJson!!}
}" class="h-full shadow-md rounded-xl group p-2 bg-gray-900 flex flex-col items-center justify-between relative">
    <template x-if="site.vpn || site.new || site.hot">
        <div class="w-full flex space-x-2 font-bold justify-end">
            <span x-show="site.new" class="py-0.5 px-1.5 rounded-md bg-gray-1000 text-indigo-300">NEW</span>
            <span x-show="site.hot" class="py-0.5 px-1.5 rounded-md bg-gray-1000 text-red-300">HOT</span>
            <span x-show="site.vpn" class="py-0.5 px-1.5 rounded-md bg-gray-1000 text-green-300">VPN</span>
        </div>
    </template>

    <div class="w-full p-4 flex-col items-center justify-center mt-auto">
        <div class="w-full h-20" :style="`background: center / contain no-repeat url(${site.image})`"></div>

        <div class="my-2 border-t border-b py-3 border-gray-600 w-full flex justify-center items-center">
            <div class="bg-gradient-to-br from-gray-700 to-gray-800 w-full h-[125px] rounded-md" style="-webkit-mask-image: radial-gradient(circle at right 8.5px bottom 49px, transparent 8.5px, rgb(255, 255, 255) 8.75px), radial-gradient(circle closest-side at 50% center, rgb(255, 255, 255) 99%, transparent 100%); -webkit-mask-size: 100%, 9.5px 5px; -webkit-mask-repeat: repeat, repeat-x; -webkit-mask-position: 8.5px center, 50% calc(100% - 46.5px); -webkit-mask-composite: source-out;">
                <div class="h-[74px] p-1 flex items-center justify-center"><span class="text-gray-200 text-xl text-center" x-text="site.price"></span></div>
                <div class="h-[51px] p-1 flex items-center justify-center"><span class="text-gray-100 text-sm font-bold text-center" x-text="site.promo"></span></div>
            </div>
        </div>

        <div class="w-full flex flex-col mt-auto space-y-2">
            {{-- Инструкция --}}
            <template x-if="site.instruction">
                <div x-data="{ is_open: false }">
                    <x-buttons.default @click="is_open = true" color="orange">
                        Инструкция
                    </x-buttons.default>

                    <x-modal is-open="is_open">
                        <div class="text-white p-5 rounded-md bg-gray-800 w-full sm:w-fit" x-html="site.instruction"></div>
                    </x-modal>
                </div>
            </template>

            {{-- Ссылка --}}
            <template x-if="site.link">
                <a :href="site.link" target="_blank">
                    <x-buttons.default color="orange">
                        Получить халяву
                    </x-buttons.default>
                </a>
            </template>
            
            {{-- Задания --}}
            <template x-if="site.quests.length > 0">
                <a :href="`#/site/${site.id}`">
                    <x-buttons.default color="green">
                        Задания
                    </x-buttons.default>
                </a>
            </template>

            <template x-if="site.quests.length == 0">
                <x-buttons.default disabled color="gray">
                    Нет заданий
                </x-buttons.default>
            </template>
        </div>
    </div>
</div>
