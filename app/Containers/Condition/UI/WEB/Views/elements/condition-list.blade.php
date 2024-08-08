<div class="flex flex-col space-y-4 max-w-6xl bg-gray-800 p-5 rounded-md">
    <p class="text-gray-50">Внимание! Вы должны выполнить условия:</p>

    <div class="flex flex-col space-y-3">
        <template x-for="(platform, platformName) in {{$alpine__condition}}.action">
            <template x-if="platformName != 'any'">
                <div class="flex flex-col space-y-1">
                    {{-- Platfrom name --}}
                    <span class="text-white text-md" x-text="platform.name"></span>
                    {{-- Likes --}}
                    <template x-if="platform.likes">
                        <div class="flex flex-col space-y-1">
                            <template x-for="item in platform.likes">
                                <a target="_blank" :href="item.link_player ?? item.link">
                                    @component('condition::elements.condition-list-item')
                                        <p>Поставить лайк</p>
                                    @endcomponent
                                </a>
                            </template>
                        </div>
                    </template>
                    {{-- Subscribes --}}
                    <template x-if="platform.subscribes">
                        <div class="flex flex-col space-y-1">
                            <template x-for="item in platform.subscribes">
                                <a target="_blank" :href="item.link_player ?? item.link">
                                    @component('condition::elements.condition-list-item')
                                        <p>Подписаться на группу</p>
                                    @endcomponent
                                </a>
                            </template>
                        </div>
                    </template>
                    {{-- Reposts --}}
                    <template x-if="platform.reposts">
                        <div class="flex flex-col space-y-1">
                            <template x-for="item in platform.reposts">
                                <a target="_blank" :href="item.link_player ?? item.link">
                                    @component('condition::elements.condition-list-item')
                                        <p>Сделать репост записи</p>
                                    @endcomponent
                                </a>
                            </template>
                        </div>
                    </template>
                    {{-- Messages --}}
                    <template x-if="platform.messages">
                        <div class="flex flex-col space-y-1">
                            <template x-for="item in platform.messages">
                                <a target="_blank" :href="item.link_player ?? `https://vk.com/` + item.vk_short_name">
                                    @component('condition::elements.condition-list-item')
                                        <p>Написать в лс: <span x-text="item.text"></span></p>
                                    @endcomponent
                                </a>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </template>
    </div>

    <template x-if="{{$alpine__condition}}.action.any">
        <div x-data="conditionAnyHandlerData({{$alpine__condition}})" class="flex flex-col space-y-3">
            <template x-for="(platformItems, platformName) in any">
                <div class="flex flex-col space-y-1">
                    {{-- Platfrom name --}}
                    <span class="text-white text-md" x-text="platformName"></span>
                    {{-- Items --}}
                    <div class="flex flex-col space-y-1">
                        <template x-for="item in platformItems">
                            <a @click="handle(item)" target="_blank" :href="item.link">
                                @component('condition::elements.condition-list-item')
                                    <p x-text="item.desc"></p>
                                @endcomponent
                            </a>
                        </template>
                    </div>
                </div>
            </template>
        </div>
    </template>

    <x-banners.default class="rounded" color="gray" title="Рекламодатель? Добавь свои условия!">
        <div class="flex flex-col text-sm py-2">
            <x-buttons.cooperation />
        </div>
    </x-banners.default>
</div>
