<div x-data="credentialsData()" class="grid grid-cols-1 md:grid-cols-2 gap-2 rounded-md bg-gray-900">
    {{-- Player card --}}
    <div class="flex flex-col items-center justify-start space-y-3 p-4 bg-gray-1000 bg-opacity-20" x-data="{ is_payment_window_open: false }">
        <div class="w-full flex justify-start space-x-2">
            <div class="relative bg-contain bg-no-repeat w-20 h-20 rounded-lg" :style="'background-image: url(' + $store.player.player.image +')'"></div>
            <div class="flex flex-col">
                <span class="text-white text-2xl font-bold">
                    <span>ID: <span x-text="$store.player.player.id"></span></span>
                    <span x-text="$store.player.player.name"></span>
                </span>

                <span class="inline-flex space-x-1 items-center text-green-300 text-lg">
                    <span x-text="$store.player.player.balance"></span><x-icons.currency />
                </span>
            </div>
        </div>

        <span class="w-full">
            <x-buttons.default @click="is_payment_window_open = true" color="green" size="normal">
                <i class="fas fa-wallet"></i> <span class="ml-1">Пополнить</span>
            </x-buttons.default>
        </span>

        {{-- Trade link --}}
        <div class="w-full space-y-1 flex flex-col">
            <label class="space-x-2 flex items-center"> <span class="text-gray-500 text-xs uppercase"><i class="far fa-link"></i> Ссылка на трейд</span><a class="text-indigo-300 text-xs" target="_blank" href="https://steamcommunity.com/profiles/76561197997014446/tradeoffers/privacy#trade_offer_access_url">Где взять?</a></label>

            <div class="flex items-stretch w-full space-x-0.5">
                <input x-model="trade_link" class="w-full text-green-300 input-default" placeholder="https://steamcommunity.com/tradeoffer/new/?partner=99999999&token=XXXXXXXX" type="text">

                <span>
                    <x-buttons.actionable @click="tradeLink()" 
                        class="h-full" 
                        size="small" 
                        color="green" 
                        is-acting="is_setting_trade_link" 
                        action='<i class="fas fa-check-circle mr-1"></i> Сохранить' 
                    />
                </span>
            </div>
        </div>

        <x-modal is-open="is_payment_window_open">
            @include('paymentsection.payment::components.payment-window')
        </x-modal>
    </div>

    {{-- Social --}}
    <div class="flex flex-col space-y-4 p-4">
        <span class="flex flex-col space-y-1">
            <span class="text-white text-2xl font-bold">Подключенные аккаунты</span>
            <p class="text-gray-200 text-sm">ВНИМАНИЕ! Аккаунты можно отвязывать только через 7 дней, после привязки.</p>
        </span>

        {{-- Vk account --}}
        <div class="space-y-1 flex flex-col">
            <label class="space-x-2 flex items-center"><span class="{{is_null($player->vkAccount) ? 'text-gray-500' : 'text-indigo-300'}}  text-xs uppercase"><i class="fab fa-vk"></i> Аккаунт</span></label>

            <div class="flex items-stretch w-full space-x-0.5">
                <input readonly type="text" :value="$store.player.player.vkAccount == null ? 'Не привязан' : 'ID:' + $store.player.player.vkAccount.vk_id" :class="$store.player.player.vkAccount == null ? 'text-gray-500' : 'text-indigo-300'" class="w-full input-default">

                <template x-if="$store.player.player.vkAccount == null">
                    <a href="{{route('player.vk.auth')}}">
                        <x-buttons.default class="h-full" color="indigo" size="small">
                            <i class="fas fa-check-circle mr-1"></i>Привязать
                        </x-buttons.default>
                    </a>
                </template>

                <template x-if="$store.player.player.vkAccount != null">
                    <span>
                        <x-buttons.actionable @click="dettachVk()" 
                            class="h-full" 
                            color="red"
                            size="small"
                            is-acting="is_dettaching_vk" 
                            action='<i class="fas fa-times-circle"></i> Отвязать' 
                        />
                    </span>
                </template>
            </div>
        </div>

        {{-- Telegram account --}}
        <div class="space-y-1 flex flex-col">
            <label class="space-x-2 flex items-center"><span class="{{is_null($player->telegramAccount) ? 'text-gray-500' : 'text-indigo-300'}} text-xs uppercase"><i class="fab fa-telegram"></i> Аккаунт</span></label>

            <div class="flex items-stretch w-full space-x-0.5" x-data="{ is_telegram_attach_window_show: false }">
                <input readonly type="text" :value="$store.player.player.telegramAccount == null ? 'Не привязан' : 'ID:' + $store.player.player.telegramAccount.telegram_id" :class="$store.player.player.telegramAccount == null ? 'text-gray-500' : 'text-indigo-300'" class="w-full input-default">

                <template x-if="$store.player.player.telegramAccount == null">
                    <span>
                        <x-buttons.default class="h-full" @click="is_telegram_attach_window_show = true" color="indigo" size="small">
                            <i class="fas fa-check-circle mr-1"></i> Привязать
    
                            <x-modal is-open="is_telegram_attach_window_show">
                                <div class="flex flex-col p-4 rounded-lg bg-gray-900">
                                    <span class="text-white text-2xl mb-2">Привязка Telegram</span>
            
                                    <p class="text-gray-200 text-lg leading-5">Для привязки вашего аккаунта telegram, Вам необходимо <br> отправить команду нашему телеграм-боту формата "/attachВАШ_STEAM_ID"</p>
                                    <p class="text-gray-200 text-lg mt-3">Наш бот: <a class="text-indigo-300" target="_blank" href="https://telegram.me/{{$telegram_bot_name}}">https://telegram.me/{{$telegram_bot_name}}</a></p>
                                    <p class="text-gray-200 text-lg">Команда:</p>
            
                                    <div class="flex justify-center p-2 rounded-md bg-gray-800">
                                        <input class="text-orange-300 text-3xl input-default w-full" :value="'/attach' + $store.player.player.steam_id" />
            
                                        <span class="ml-1">
                                            <x-buttons.default @click="copyToClipboard('/attach' + $store.player.player.steam_id)" color="green">
                                                <i class="fas fa-copy"></i>
                                            </x-buttons.default>
                                        </span>
                                    </div>
            
                                    <p class="mt-3 text-gray-300 text-sm">P.S. В случае успешной привязки - перезагрузите страницу на сайте</p>
                                </div>
                            </x-modal>
                        </x-buttons.default>
                    </span>
                </template>   
                
                <template x-if="$store.player.player.telegramAccount != null">
                    <span>
                        <x-buttons.actionable @click="dettachTelegram()" 
                            class="h-full" 
                            color="red"
                            size="small"
                            is-acting="is_dettaching_telegram" 
                            action='<i class="fas fa-times-circle"></i> Отвязать' 
                        />
                    </span>
                </template>
            </div>
        </div>
    </div>
</div>
