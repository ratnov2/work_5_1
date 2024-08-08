<div x-data="chatData()" class="relative flex flex-col h-full w-full transition-all duration-150">
    <div class="flex items-center justify-between w-full px-6 flex-shrink-0 h-20 border-b border-gray-800 bg-gray-900 rounded-t-md">
        <div class="flex flex-col">
            <!-- Chat rules -->
            <div @click.away="is_open_rules = false" x-show="is_open_rules" style="box-shadow: 0 0 20px 10px #1a1820;" x-transition class="shadow-lg z-50 absolute left-0 lg:left-auto top-20 lg:top-0 lg:right-full w-full lg:w-96 rounded-md bg-gray-900">
                <div class="bg-gray-800 bg-opacity-50 p-5 lg:p-10 rounded-md">
                    <span class="hidden md:block absolute left-full top-5 text-gray-800 opacity-90 text-4xl">
                        <i class=" fas fa-caret-right"></i>
                    </span>

                    <p class="text-xl font-bold text-gray-50">В чате запрещено:</p>

                    <ul class="list-disc text-gray-200 text-sm ml-4">
                        <li>Сливать промо / секретные коды</li>
                        <li>Попрошайничать</li>
                        <li>Оскорблять администрацию</li>
                        <li>Показывать чрезмерную агрессию и негатив</li>
                        <li>Обвинять администрацию сайта или сайт в обмане</li>
                        <li>Рекламировать сторонние ресурсы</li>
                        <li>Спамить / Флудить</li>
                    </ul>
                    <p class="mt-5 text-green-300 text-sm leading-4">Будьте вежливы и уважайте остальных игроков. Приятного проведения времени на сайте!</p>
                </div>
            </div>

            <button @click="is_open_rules = !is_open_rules" class="text-xs text-green-300">Правила чата</button>
        </div>
    </div>

    <div id="messages-area" class="h-96 overflow-y-scroll overflow-x-hidden bg-gray-900 bg-opacity-50 flex-grow py-4 pl-4 pr-2">
        <div class="space-y-3 flex flex-col">
            <template x-for="(message, index) in messages" :key="index + '-' + message.uid">
                @if(Auth::guard('players')->check() && Auth::guard('players')->user()->can('moderate-chat'))
                    <div x-data="moderatorChatData()" @contextmenu.away="is_show_context_menu = false" @contextmenu="$event.preventDefault(); is_show_context_menu = true" class="relative">
                        @component('chat::elements.message-card')@endcomponent
                        @component('chat::elements.moderator-context-menu')@endcomponent
                    </div>
                @else
                    @component('chat::elements.message-card')@endcomponent
                @endif
            </template>
        </div>
    </div>

    <template x-if="$store.player.player !== null">
        <div class="flex justify-center items-center flex-shrink-0 bg-gray-900 w-full border-t border-gray-800 rounded-b-md relative">
            <div class="flex items-center justify-center w-full space-x-2">
                <div class="flex w-full h-full p-4 items-scretch space-x-1" x-data="{ is_shift_pressed: false }">
                    <textarea x-ref="messageTextarea"
                        @keydown.shift="is_shift_pressed = true"
                        @keyup.shift="is_shift_pressed = false"
                        @keydown.enter="if(!is_shift_pressed) { $event.preventDefault(); sendMsg() }"
                        x-model="input_message"
                        class="p-2 h-10 rounded bg-gray-700 bg-opacity-40 rounded-md resize-none text-gray-50 text-xs w-full focus:outline-none"
                    >
                    </textarea>

                    <button :disabled="is_sending_message" @click="sendMsg()" class="flex items-center justify-center flex-shrink-0 w-10 h-10 bg-indigo-300 text-center text-gray-1000 p-2 rounded-md">
                        <i x-show="!is_sending_message" class="fad fa-paper-plane"></i>
                        <template x-if="is_sending_message">
                            <x-icons.spinner />
                        </template>
                    </button>
                </div>
            </div>
        </div>
    </template>

    <template x-if="$store.player.player === null">
        <div class="relative h-48 rounded-md overflow-hidden flex items-center justify-center mt-2">
            <span class="absolute opacity-20 text-[120px]"><i class="fad fa-paper-plane"></i></span>

            <x-banners.auth />
        </div>
    </template>
</div>

