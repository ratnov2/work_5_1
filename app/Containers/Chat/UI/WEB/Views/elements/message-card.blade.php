<div
    @click.prevent="input_message = '@' + message.player.name + ', '"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="transform origin-top scale-y-0"
    x-transition:enter-end="transform origin-top scale-y-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="transform origin-top scale-y-100"
    x-transition:leave-end="transform origin-top scale-y-0"
    class="rounded-tl-xl rounded-tr-md rounded-br-xl rounded-bl-md bg-gray-700 bg-opacity-20 p-2 w-full flex items-start space-x-1"
>
    <div class="w-10 h-10 rounded-xl bg-contain bg-no-repeat flex-shrink-0" :style="{ 'background-image': 'url(' + message.player.image + ')' }"></div>

    <div class="flex flex-col w-full">
        <div class="flex justify-between">
            <div class="inline-flex space-x-1 items-center flex-wrap">
                <template x-if="message.player.roles?.find(role => role.slug == 'admin')">
                    <x-badges.default color="yellow" size="small">
                        <span x-text="message.player.roles.find(role => role.slug == 'admin').name"></span>
                    </x-badges.default>
                </template>

                <template x-if="message.player.roles?.find(role => role.slug == 'moderator')">
                    <x-badges.default color="green" size="small">
                        <span x-text="message.player.roles.find(role => role.slug == 'moderator').name"></span>
                    </x-badges.default>
                </template>

                <template x-if="message.player.roles?.find(role => role.slug == 'developer')">
                    <x-badges.default color="purple" size="small">
                        <span x-text="message.player.roles.find(role => role.slug == 'developer').name"></span>
                    </x-badges.default>
                </template>

                <template x-if="message.player.roles?.find(role => role.slug == 'blogger')">
                    <x-badges.default color="red" size="small">
                        <span x-text="message.player.roles.find(role => role.slug == 'blogger').name"></span>
                    </x-badges.default>
                </template>

                <span class="text-gray-200 text-md max-w-32 line-clamp-1 whitespace-nowrap text-ellipsis overflow-hidden" x-text="message.player.name"></span>
            </div>

            <span class="text-gray-500 text-xs" x-text="convertTimestamp(message.time)"></span>
        </div>

        <p class="break-all text-gray-300 text-xs opacity-60 pl-1" x-text="message.msg"></p>
    </div>
</div>
