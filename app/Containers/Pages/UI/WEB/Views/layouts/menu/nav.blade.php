@php
    $routes = [
        ['hash' => '#', 'title' => 'Халява', 'icon' => '<i class="fas fa-gift"></i>'],
        ['hash' => '#/contests', 'title' => 'Розыгрыши', 'icon' => '<i class="fas fa-gift"></i>'],
        ['hash' => '#/boxes', 'title' => 'Бесплатные кейсы', 'icon' => '<i class="fas fa-box"></i>'],
        ['hash' => '#/game-modes', 'title' => 'Игры', 'icon' => '<i class="fas fa-dice"></i>'],
        ['hash' => '#/ref-system', 'title' => 'Партнерство', 'icon' => '<i class="fas fa-hands-helping"></i>'],
    ];
@endphp

<nav class="list-none flex items-center md:justify-center w-full rounded-tr-xl rounded-tl-xl bg-gray-1000 bg-opacity-50 divide-x divide-gray-800 px-0 lg:px-7 overflow-y-hidden overflow-x-auto">
    @foreach ($routes as $route)
        <a  href="{{ $route['hash'] }}"
            class="cursor-pointer justify-stretch flex items-center px-6 py-2 h-full text-xs text-gray-400 font-extrabold uppercase"
            :class="$store.router.loading_route?.hash === ('{{ $route['hash'] }}')
                ? 'text-orange-300 bg-gray-800'
                : $store.router.current_route?.hash === ('{{ $route['hash'] }}') && $store.router.loading_route == null
                ? 'text-orange-300 bg-gray-800'
                : ''
            "
        >
            <span class="flex gap-1 items-center text-sm whitespace-nowrap">
                {!! $route['icon'] !!} <span class="inline-block uppercase">{{ $route['title'] }}</span>
            </span>
        </a>
    @endforeach
</nav>
