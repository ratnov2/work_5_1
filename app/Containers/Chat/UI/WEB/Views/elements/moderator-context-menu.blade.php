<div @click.away="is_show_context_menu = false" class="absolute top-full left-1 w-fit z-30" x-show="is_show_context_menu"
    x-transition:enter="transition ease duration-100 transform"
    x-transition:enter-start="opacity-0 scale-90 translate-y-1"
    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
    x-transition:leave="transition ease duration-100 transform"
    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
    x-transition:leave-end="opacity-0 scale-90 translate-y-1"
>
    <span class="absolute top-0 left-0 w-2 h-2 bg-white transform rotate-45 -mt-1 ml-3 border-gray-300 border-l border-t z-20"></span>
    <div class="bg-white overflow-auto rounded-lg shadow-md w-full relative z-10 py-2 border border-gray-300 text-gray-800 text-xs">
        <ul class="list-reset relative">
            <div x-show="is_proccessing" class="absolute flex z-30 w-full h-full justify-center items-center bg-white">
                <div class="inline-flex w-5 h-5">
                    <x-icons.spinner />
                </div>
            </div>
            <li>
                <button @click="mutePlayer(message.player.id, 86400)" class="px-4 py-1 flex hover:bg-gray-100 no-underline hover:no-underline transition-colors duration-100">Дать мут на 24 часов</button>
                <button @click="mutePlayer(message.player.id, 43200)" class="px-4 py-1 flex hover:bg-gray-100 no-underline hover:no-underline transition-colors duration-100">Дать мут на 12 часов</button>
                <button @click="mutePlayer(message.player.id, 3600)" class="px-4 py-1 flex hover:bg-gray-100 no-underline hover:no-underline transition-colors duration-100">Дать мут на 1 час</button>
                <button @click="mutePlayer(message.player.id, 1800)" class="px-4 py-1 flex hover:bg-gray-100 no-underline hover:no-underline transition-colors duration-100">Дать мут на 30 минут</button>
                <button @click="mutePlayer(message.player.id, 600)" class="px-4 py-1 flex hover:bg-gray-100 no-underline hover:no-underline transition-colors duration-100">Дать мут на 10 минут</button>
                <button @click="mutePlayer(message.player.id, 120)" class="px-4 py-1 flex hover:bg-gray-100 no-underline hover:no-underline transition-colors duration-100">Дать мут на 2 минуты</button>
                <button @click="unmutePlayer(message.player.id)" class="px-4 py-1 flex hover:bg-gray-100 no-underline hover:no-underline transition-colors duration-100 text-green-300">Снять мут</button>
                <button @click="messageDelete(message.uid)" class="px-4 py-1 flex hover:bg-gray-100 no-underline hover:no-underline transition-colors duration-100 text-red-500">Удалить сообщение</button>
            </li>
        </ul>
    </div>
</div>
