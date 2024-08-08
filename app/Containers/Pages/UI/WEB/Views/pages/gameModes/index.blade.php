<div class="grid grid-cols-1 lg:grid-cols-12 items-start gap-2 lg:-mx-5 lg:h-[700px] overflow-hidden">
    {{-- Invent --}}
    <div class="col-span-1 lg:col-span-3 h-[300px] lg:h-[700px]">
        <template x-if="$store.player.player != null">@component('gamemodes::components.invent')@endcomponent</template>

        <template x-if="$store.player.player == null">
            <div class="h-full rounded-md overflow-hidden relative items-center justify-center">
                <img class="absolute w-4/5 opacity-20" src="{{asset('img/jackpot/ak47.png')}}" alt="ak47">
                <x-banners.auth />
            </div>
        </template>
    </div>

    {{-- Games --}}
    <div class="col-span-1 lg:col-span-6 flex flex-col lg:h-[700px]">
        @php
            $routes = [
                ['hash' => '#/game-modes/top-contest', 'title' => 'ТОП', 'icon' => '<i class="fad fa-trophy-alt"></i>'],
                ['hash' => '#/game-modes/jackpot', 'title' => 'Джекпот', 'icon' => '<i class="fad fa-circle-notch"></i>'],
                ['hash' => '#/game-modes/upgrade', 'title' => 'Апгрейд', 'icon' => '<i class="fad fa-chevron-double-up"></i>'],
                ['hash' => '#/game-modes/boxes', 'title' => 'Кейсы', 'icon' => '<i class="fad fa-box"></i>'],
                ['hash' => '#/game-modes/mines', 'title' => 'Мины', 'icon' => '<i class="fas fa-bomb"></i>'],
            ];
        @endphp

        <nav class="bg-gray-900 flex flex-shrink-0 justify-start rounded-md overflow-x-auto overflow-y-hidden divide-x divide-gray-800">
            @foreach ($routes as $route)
                <a href="{{ $route['hash'] }}" class="cursor-pointer justify-stretch flex items-center px-6 py-2 text-gray-400 flex-col -space-y-1"
                    :class="$store.router.loading_route?.hash.startsWith('{{ $route['hash'] }}')
                        ? 'text-orange-300 bg-gray-800'
                        : $store.router.current_route?.hash.startsWith('{{ $route['hash'] }}') && $store.router.loading_route == null
                        ? 'text-orange-300 bg-gray-800'
                        : ''
                    "
                >
                    <span class="text-2xl">{!! $route['icon'] !!}</span>
                    <span class="text-xs">{{ $route['title'] }}</span>
                </a>
            @endforeach
        </nav>

        {{-- Router view --}}
        <div x-data="routerView('gameModes')" @hashchange.window="onHashChange()" class="w-full pt-2" style="height: calc(100% - 60px)">
            <div class="w-full h-full"></div>
            <template x-if="loading_route?.name == 'gameModes.topContest'">@component('pages::pages.gameModes.pages.topContest.skeleton.index')@endcomponent</template>
            <template x-if="loading_route?.name == 'gameModes.jackpot'">@component('pages::pages.gameModes.pages.jackpot.skeleton.index')@endcomponent</template>
            <template x-if="loading_route?.name == 'gameModes.upgrade'">@component('pages::pages.gameModes.pages.upgrade.skeleton.index')@endcomponent</template>
            <template x-if="loading_route?.name == 'gameModes.boxes'">@component('pages::pages.gameModes.pages.boxes.skeleton.index')@endcomponent</template>
            <template x-if="loading_route?.name == 'gameModes.mines'">@component('pages::pages.gameModes.pages.mines.skeleton.index')@endcomponent</template>
            <template x-if="loading_route?.name == 'gameModes.box'">@component('pages::pages.gameModes.pages.box.skeleton.index')@endcomponent</template>
        </div>
    </div>

    {{-- Chat --}}
    <div class="col-span-1 lg:col-span-3 h-[300px] lg:h-[700px]">
        @component('chat::components.chat')@endcomponent
    </div>
</div>
