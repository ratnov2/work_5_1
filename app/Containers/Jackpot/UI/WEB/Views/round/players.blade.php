<div class="px-2 flex flex-grow justify-start items-center overflow-x-auto bg-gradient-to-r from-gray-800 to-gray-900 flex-nowrap space-x-2 relative h-full">
    <template x-for="player_info in {{$alpine__players_info}}" :key="'players_info' + player_info.player.id">
        <div class="flex flex-col items-center">
            <div class="rounded-md w-9 h-9 bg-gray-400 bg-cover bg-center bg-no-repeat relative border-2"
                :style="{
                    backgroundImage: `url(${player_info.player.image})`,
                    borderColor: `${player_info.color}`
                }"
            ></div>
            <span class="text-xs text-gray-200">
                <span x-text="roundLikePHP(player_info.precent, 2)"></span>%
            </span>
        </div>
    </template>
</div>
